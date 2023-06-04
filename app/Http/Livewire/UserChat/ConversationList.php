<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ConversationList extends Component
{
    public Group $group;
    public Collection $messages;

    protected $listeners = [
        'messageSent' => 'refreshMessage',
        'messageReceived' => 'refreshMessage',
    ];

    public function mount()
    {
        $this->messages = $this->getMessages();
    }

    public function render()
    {
        return view('chat.partials.user-chat.conversation-list');
    }

    public function refreshMessage(Message $message)
    {
        $this->messages->push($message);
    }

    protected function getMessages()
    {
        return $this->group->messages()
            ->latest()
            ->simplePaginate(10)
            ->getCollection()
            ->reverse();
    }
}
