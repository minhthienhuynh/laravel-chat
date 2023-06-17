<?php

namespace App\Http\Livewire\LeftSidebar;

use App\Http\Livewire\Traits\LeftSidebarTrait;
use App\Models\Room;
use Livewire\Component;

class TabpaneChats extends Component
{
    use LeftSidebarTrait;

    protected $listeners = [
        'messageReceived' => 'refreshRooms',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.tabpane-chats');
    }

    public function refreshRooms($messageId, Room $room)
    {
        $this->updateChatTabPane($room);
    }
}
