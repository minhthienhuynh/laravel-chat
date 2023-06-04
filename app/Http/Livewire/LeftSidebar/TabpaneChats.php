<?php

namespace App\Http\Livewire\LeftSidebar;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TabpaneChats extends Component
{
    public Collection $users;
    public Collection $groups;

    public function mount()
    {
        $this->users = User::whereKeyNot(auth()->id())
            ->orderBy('name')
            ->select('*')
            ->get();
        $this->groups = Group::where('type', Group::TYPE_GROUP)
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->get();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.tabpane-chats');
    }
}
