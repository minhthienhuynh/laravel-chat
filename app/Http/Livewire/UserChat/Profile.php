<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use App\Models\User;
use Livewire\Component;

class Profile extends Component
{
    public ?Group $group;
    public ?User $user;

    protected $listeners = [
        'contactSelected' => 'renderProfile',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.profile-details');
    }

    public function renderProfile(Group $group)
    {
        $this->group = $group;

        if ($group->type == Group::TYPE_USER) {
            $this->user = $group->other_users->first();
        } else {
            $this->user = null;
        }
    }
}
