<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Group;
use Livewire\Component;

class Topbar extends Component
{
    public ?Group $group;

    protected $listeners = [
        'contactSelected' => 'renderTopbar',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.topbar');
    }

    public function renderTopbar(Group $group)
    {
        $this->group = $group;

        if ($group->type == Group::TYPE_USER) {
            $this->user = $group->other_users->first();
        } else {
            $this->user = null;
        }
    }
}
