<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Profile extends Component
{
    public ?Group $group;
    public ?User $user;
    public Collection $commonGroups;

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

            $this->commonGroups = Group::query()
                ->whereHas('users', function (Builder $query) {
                    $query->where('id', auth()->id());
                })
                ->whereHas('users', function (Builder $query) {
                    $query->where('id', $this->user->id);
                })
                ->where('type', Group::TYPE_GROUP)
                ->get();
        } else {
            $this->user = null;
        }
    }

    public function setFavourite($id)
    {
        $options = auth()->user()->options;
        $key = array_search($id, $options['group-favorites']);

        if ($key === false) {
            $options['group-favorites'][] = $id;
        } else {
            unset($options['group-favorites'][$key]);
        }

        auth()->user()->options = $options;
        auth()->user()->push();

        $this->emit('favoriteUpdated');
    }
}
