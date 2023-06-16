<?php

namespace App\Http\Livewire\UserChat;

use App\Events\NewMessage;
use App\Models\Room;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;

class ForwardModal extends Component
{
    public Collection $rooms;
    public ?Message $message = null;
    public string $content = '';

    protected $listeners = [
        'messageForwarding' => 'forwardMessage',
    ];

    protected array $rules = [
        'content' => 'string',
    ];

    public function mount()
    {
        $this->rooms = Room::whereKeyNot(auth()->id())
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->with('other_users')
            ->get();

        $this->rooms->map(function (Room $room) {
            if ($room->isUserType()) {
                $room->display_name = $room->other_users->first()->name;
            } else {
                $room->display_name = $room->name;
            }

            $room->list_title = strtoupper($room->display_name)[0];
        })
        ->sortBy('list_title');
    }

    public function render()
    {
        return view('chat.partials.user-chat.forward-modal');
    }

    public function forwardMessage(Message $message)
    {
        $this->message = $message;
    }

    public function send(Room $room)
    {
        try {
            $this->validate();

            $message = $room->messages()->create([
                'content' => $this->content,
                'user_id' => auth()->id(),
                'options' => ['forward' => $this->message->toArray()],
            ]);

            broadcast(new NewMessage($message));
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }
    }

    public function resetModal()
    {
        $this->reset('content');
    }
}
