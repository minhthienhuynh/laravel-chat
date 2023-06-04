<?php

namespace App\Http\Livewire\LeftSidebar\Chats;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Favourites extends Component
{
    public Collection $groups;

    public function mount()
    {
        $this->groups = Group::query()
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->where('type', Group::TYPE_USER)
            ->whereIn('id', auth()->user()->options['group-favorites'])
            ->with('other_users')
            ->get();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.chats.favourites');
    }
}
