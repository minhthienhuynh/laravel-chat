<?php

namespace App\Http\Livewire\UserChat;

use App\Events\NewMessageTyping;
use App\Models\Room;
use Livewire\Component;

class ConversationSection extends Component
{
    public ?Room $room;

    protected $listeners = [
        'contactSelected' => 'renderConversation',
        'userTyping' => 'userTyping',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.conversation-section');
    }

    public function renderConversation(Room $room)
    {
        $this->room = $room;
        $this->emit('focusOnChatInput');
        $this->emit('scrollToUnreadMessage');
    }

    public function userTyping()
    {
        broadcast(new NewMessageTyping($this->room))->toOthers();
    }
}
