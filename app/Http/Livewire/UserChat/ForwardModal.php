<?php

namespace App\Http\Livewire\UserChat;

use App\Events\NewMessage;
use App\Models\Room;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ForwardModal extends Component
{
    public Collection $rooms;
    public ?Message $message = null;
    public string $content = '';
    public array $selectedRooms = [];

    protected $listeners = [
        'contactSelected' => 'renderModal',
        'messageForwarding' => 'forwardMessage',
    ];

    protected array $rules = [
        'content' => 'string',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.forward-modal');
    }

    public function renderModal(Room $room)
    {
        $this->rooms = $this->getForwardRooms($room);
    }

    public function forwardMessage(Message $message)
    {
        $this->message = $message;
    }

    public function send(Room $room)
    {
        $this->validate();

        $message = $room->messages()->create([
            'content' => $this->content,
            'user_id' => auth()->id(),
            'options' => ['forward' => $this->message->toArray()],
        ]);

        $this->selectedRooms[] = $room->id;

        broadcast(new NewMessage($message));
    }

    public function resetModal()
    {
        $this->reset('content', 'selectedRooms');
    }

    protected function getForwardRooms(Room $room)
    {
        return Room::query()
            ->whereKeyNot($room->id)
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->with('other_users')
            ->get();
    }
}
