<?php

namespace App\Http\Livewire\UserChat;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Profile extends Component
{
    public ?Room $room;
    public ?User $user;
    public Collection|array $commonRooms;

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

    public function renderProfile(Room $room)
    {
        $this->room = $room;

        if ($room->type == Room::TYPE_USER) {
            $this->user = $room->other_users->first();
            $this->commonRooms = $this->getCommonRooms();
        } else {
            $this->user = null;
        }
    }

    public function setFavourite($id)
    {
        $options = auth()->user()->options;
        $key = array_search($id, $options['room-favorites']);

        if ($key === false) {
            $options['room-favorites'][] = $id;
        } else {
            unset($options['room-favorites'][$key]);
        }

        auth()->user()->options = $options;
        auth()->user()->push();

        $this->emit('favoriteUpdated');
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
            ->where('type', Room::TYPE_GROUP)
            ->get();
    }
}
