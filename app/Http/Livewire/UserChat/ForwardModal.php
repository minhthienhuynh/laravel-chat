<?php

namespace App\Http\Livewire\UserChat;

use App\Events\MessageSent;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;

class ForwardModal extends Component
{
    public Collection $groups;
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
        $this->groups = Group::whereKeyNot(auth()->id())
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->with('other_users')
            ->get();

        $this->groups->map(function (Group $group) {
            if ($group->type == Group::TYPE_USER) {
                $group->display_name = $group->other_users->first()->name;
            } else {
                $group->display_name = $group->name;
            }

            $group->list_title = strtoupper($group->display_name)[0];
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

    public function send(Group $group)
    {
        try {
            $this->validate();

            $message = Message::create([
                'content' => $this->content,
                'group_id' => $group->id,
                'user_id' => auth()->id(),
                'options' => ['forward' => $this->message->toArray()],
            ]);

            broadcast(new MessageSent($message));
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }
    }

    public function resetModal()
    {
        $this->reset('content');
    }
}
