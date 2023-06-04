<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use Livewire\Component;

class GroupProfile extends Component
{
    public Group $group;

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.group-profile-details');
    }
}
