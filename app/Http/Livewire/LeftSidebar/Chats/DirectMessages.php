<?php

namespace App\Http\Livewire\LeftSidebar\Chats;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class DirectMessages extends Component
{
    public Collection|array $groups;

    protected $listeners = [
        'favoriteUpdated' => 'refreshGroups',
    ];

    public function mount()
    {
        $this->groups = $this->getGroups();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.chats.direct-messages');
    }

    public function refreshGroups()
    {
        $this->groups = $this->getGroups();
    }

    protected function getGroups(): Collection|array
    {
        return Group::query()
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->whereIn('id', auth()->user()->options['group-favorites'], 'and', true)
            ->where('type', Group::TYPE_USER)
            ->with('other_users')
            ->get();
    }
}
