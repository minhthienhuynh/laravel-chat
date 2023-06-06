<?php

namespace App\Http\Livewire\LeftSidebar\Chats;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddContactModal extends Component
{
    public Collection $users;

    public function mount()
    {
        $this->users = $this->getUnconnectedUsers();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.chats.add-contact-modal');
    }

    public function selectUser(User $user)
    {
        if ($this->hasGroup($user)) {
            return;
        }

        $group = Group::create([
            'type' => Group::TYPE_USER,
        ]);

        $group->users()->sync([auth()->id(), $user->id]);

        $this->emit('contactUserStored', $group->id);
    }

    protected function getUnconnectedUsers()
    {
        $groups = Group::query()
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->where('type', Group::TYPE_USER)
            ->get();

        return User::whereKeyNot(auth()->id())
            ->whereDoesntHave('groups', function(Builder $query) use ($groups) {
                $query->whereIn('id', $groups->pluck('id'));
            })
            ->orderBy('name')
            ->select('*')
            ->addSelect(DB::raw("UPPER(LEFT(name, 1)) as upper_left_name_1"))
            ->get();
    }

    protected function hasGroup(User $user)
    {
        return Group::query()
            ->has('users', '=', 2)
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->whereHas('users', function (Builder $query) use ($user) {
                $query->where('id', $user->id);
            })
            ->where('type', Group::TYPE_USER)
            ->exists();
    }
}
