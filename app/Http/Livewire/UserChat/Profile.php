<?php

namespace App\Http\Livewire\UserChat;

use App\Http\Livewire\Traits\LeftSidebarTrait;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Profile extends Component
{
    use LeftSidebarTrait;

    public Room $room;
    public ?User $user = null;
    public Collection|array $commonRooms;

    public function mount()
    {
        if ($this->room->isUserType()) {
            $this->commonRooms = $this->getCommonRooms();
        }
    }

    public function render()
    {
        return view('chat.partials.user-chat.profile-details');
    }

    public function setFavourite(Room $room)
    {
        $options = auth()->user()->options;
        $key = array_search($room->id, $options['room-favorites']);

        if ($key === false) {
            $options['room-favorites'][] = $room->id;
        } else {
            unset($options['room-favorites'][$key]);
        }

        auth()->user()->options = $options;
        auth()->user()->push();

        $this->updateChatTabPane($room, true);
    }

    protected function getCommonRooms(): Collection|array
    {
        return Room::query()
            ->whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->whereHas('users', function (Builder $query) {
                $query->where('id', $this->user->id);
            })
            ->ofType(Room::TYPE_GROUP)
            ->get();
    }
}
