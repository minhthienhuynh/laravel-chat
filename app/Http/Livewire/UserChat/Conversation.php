<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Conversation extends Component
{
    public ?Group $group;
    public Collection $messages;

    protected $listeners = [
        'contactSelected' => 'renderMessages',
        'messageSent' => 'refreshMessages',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.conversation');
    }

    public function renderMessages(Group $group)
    {
        $this->group = $group;
        $this->messages = $this->getMessages();
    }

    public function refreshMessages(Message $message)
    {
        $this->messages->push($message);
    }

    public function messageReceived(Message $message)
    {
        $this->messages->push($message);
    }

    public function deleteMessage(Message $message)
    {
        $message->delete();

        $this->messages->map(function (Message $item) use ($message) {
            if ($item->id == $message->id) {
                $item->deleted_at = $message->deleted_at;
            }
        });
    }

    protected function getMessages()
    {
        return $this->group->messages()
            ->latest()
            ->withTrashed()
            ->simplePaginate(10)
            ->getCollection()
            ->reverse();
    }
}
