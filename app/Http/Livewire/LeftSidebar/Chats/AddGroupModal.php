<?php

namespace App\Http\Livewire\LeftSidebar\Chats;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddGroupModal extends Component
{
    public Collection $users;
    public ?string $name = '';
    public ?string $description = '';
    public ?array $user_ids = [];

    protected array $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'user_ids' => 'nullable|array',
    ];

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
        return view('chat.partials.leftsidebar.chats.add-group-modal');
    }

    public function store()
    {
        $this->validate();

        $room = Room::create([
            'name' => $this->name,
            'description' => $this->description,
            'type' => Room::TYPE_GROUP,
        ]);

        $room->users()->sync([auth()->id()] + $this->user_ids);

        $this->resetForm();

        $this->emit('groupRoomStored', $room->id);
    }

    public function resetForm()
    {
        $this->reset('name', 'description', 'user_ids');
        $this->resetValidation();
    }
}
