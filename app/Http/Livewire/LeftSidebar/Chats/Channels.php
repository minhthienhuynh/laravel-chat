<?php

namespace App\Http\Livewire\LeftSidebar\Chats;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Channels extends Component
{
    public Collection $groups;

    protected $listeners = ['groupStored' => 'refreshGroups'];

    public function mount()
    {
        $this->groups = Group::query()
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->where('type', Group::TYPE_GROUP)
            ->get();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.chats.channels');
    }

    public function refreshGroups(Group $group)
    {
        $this->groups->push($group);
    }
}
