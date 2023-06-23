<?php

namespace App\Http\Livewire\UserChat;

use App\Events\NewMessageTyping;
use App\Http\Livewire\Traits\LeftSidebarTrait;
use App\Models\Room;
use App\Models\User;
use Livewire\Component;

class ChatContent extends Component
{
    use LeftSidebarTrait;

    public ?Room $room = null;
    public ?User $user = null;

    protected $listeners = [
        'contactSelected' => 'renderRoom',
        'userTyping' => 'userTyping',
        'userLeaving' => 'leaveRoom',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.chat-content');
    }

    public function renderRoom(Room $room)
    {
        $this->room = $room;

        if ($room->isUserType()) {
            $this->user = $room->other_users->first();
        } else {
            $this->reset('user');
        }

        $this->emit('focusOnChatInput');
        $this->emit('scrollToUnreadMessage');
    }

    public function userTyping()
    {
        broadcast(new NewMessageTyping($this->room))->toOthers();
    }

    public function leaveRoom()
    {
        if (! $this->room) {
            return;
        }

        if ($this->room->isUserType()) {
            $this->room->delete();
        } else {
            $this->room->users()->detach(auth()->id());
        }

        $this->updateChatTabPane($this->room);

        $this->reset('room');
    }
}
