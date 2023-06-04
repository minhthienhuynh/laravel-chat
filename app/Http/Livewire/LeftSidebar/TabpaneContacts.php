<?php

namespace App\Http\Livewire\LeftSidebar;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TabpaneContacts extends Component
{
    public Collection $users;

    public function mount()
    {
        $this->users = User::whereKeyNot(auth()->id())
            ->orderBy('name')
            ->select('*')
            ->addSelect(DB::raw("UPPER(LEFT(name, 1)) as upper_left_name_1"))
            ->get();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.tabpane-contacts');
    }
}
