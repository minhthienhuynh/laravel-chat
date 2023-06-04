<?php

namespace App\Http\Livewire\UserChat;

use App\Models\User;
use Livewire\Component;

class UserProfile extends Component
{
    public User $user;

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.user-profile-details');
    }
}
