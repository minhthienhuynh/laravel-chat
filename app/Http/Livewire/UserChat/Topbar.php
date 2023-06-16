<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Room;
use App\Models\User;
use Livewire\Component;

class Topbar extends Component
{
    public Room $room;
    public ?User $user;

    public function mount()
    {
        if ($this->room->isUserType()) {
            $this->user = $this->room->other_users->first();
        }
    }

    public function render()
    {
        return view('chat.partials.user-chat.topbar');
    }
}
