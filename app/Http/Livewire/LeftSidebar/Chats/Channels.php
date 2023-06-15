<?php

namespace App\Http\Livewire\LeftSidebar\Chats;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Channels extends Component
{
    public Collection|array $rooms;

    protected $listeners = [
        'groupRoomStored' => 'refreshRooms',
        'favoriteUpdated' => 'refreshRooms2',
    ];

    public function mount()
    {
        $this->rooms = $this->getRooms();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.chats.channels');
    }

    public function refreshRooms(Room $room)
    {
        $this->rooms->push($room);
    }

    public function refreshRooms2()
    {
        $this->rooms = $this->getRooms();
    }

    protected function getRooms(): Collection|array
    {
        return Room::query()
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->whereIn('id', auth()->user()->options['room-favorites'], 'and', true)
            ->where('type', Room::TYPE_GROUP)
            ->get();
    }
}
