<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use Livewire\Component;

class ConversationSection extends Component
{
    public ?Group $group = null;

    protected $listeners = [
        'contactSelected' => 'renderConversation',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.conversation-section');
    }

    public function renderConversation(Group $group)
    {
        $oldGroup = $this->group;
        $this->group = $group;
        $this->emit('focusOnChatInput');
        $this->emit('chatSwitch', @$oldGroup->id, $group->id);
    }
}
