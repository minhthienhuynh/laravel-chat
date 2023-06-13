<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use App\Models\User;
use Livewire\Component;

class Topbar extends Component
{
    public Group $group;
    public ?User $user;

    public function mount()
    {
        if ($this->group->type == Group::TYPE_USER) {
            $this->user = $this->group->other_users->first();
        }
    }

    public function render()
    {
        return view('chat.partials.user-chat.topbar');
    }
}
