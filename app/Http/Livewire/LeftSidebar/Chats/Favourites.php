<?php

namespace App\Http\Livewire\LeftSidebar\Chats;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Favourites extends Component
{
    public Collection|array $rooms;

    protected $listeners = [
        'favoriteUpdated' => 'refreshRooms',
    ];

    public function mount()
    {
        $this->rooms = $this->getRooms();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.chats.favourites');
    }

    public function refreshRooms()
    {
        $this->rooms = $this->getRooms();
    }

    protected function getRooms(): Collection|array
    {
        return Room::query()
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->whereIn('id', auth()->user()->options['room-favorites'])
            ->orderBy('type')
            ->with('other_users')
            ->get();
    }
}
