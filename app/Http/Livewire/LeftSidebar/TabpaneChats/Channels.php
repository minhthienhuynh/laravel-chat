<?php

namespace App\Http\Livewire\LeftSidebar\TabpaneChats;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Channels extends Component
{
    public array|Collection $rooms;

    protected $listeners = [
        'groupRoomStored' => 'refreshRooms',
        'needRerender' => 'refreshRooms2',
    ];

    public function mount()
    {
        $this->rooms = $this->getRooms();
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.tabpane-chats.channels');
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
            ->ofType(Room::TYPE_GROUP)
            ->get();
    }
}
