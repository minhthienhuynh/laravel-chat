<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Content extends Component
{
    public ?Group $group;
    public ?User $user;

    protected $listeners = ['contactSelected' => 'openChat'];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.chat-content');
    }

    public function openChat($contactId, $groupType)
    {
        switch ($groupType) {
            case Group::TYPE_USER:
                $this->user = User::find($contactId);

                $this->group = Group::has('users', '=', 2)
                    ->where('type', Group::TYPE_USER)
                    ->whereHas('users', function (Builder $query) {
                        $query->where('id', $this->user->id);
                    })
                    ->whereHas('users', function (Builder $query) {
                        $query->where('id', auth()->id());
                    })
                    ->first();

                if (! $this->group) {
                    $this->group = Group::create(['type' => Group::TYPE_USER]);
                    $this->group->users()->sync([auth()->id(), $this->user->id]);
                }

                break;
            case Group::TYPE_GROUP:
                $this->group = Group::withCount('users')
                    ->where('id', $contactId)
                    ->first();
        }
    }
}
