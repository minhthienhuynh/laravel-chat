<?php

namespace App\Http\Livewire\LeftSidebar;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class TabpaneSettings extends Component
{
    use WithFileUploads;

    public $photo = null;

    public array $statuses = [
        User::STATUS_ACTIVE => ['class' => 'text-success', 'name' => 'Active'],
        User::STATUS_AWAY => ['class' => 'text-warning', 'name' => 'Away'],
        User::STATUS_DO_NOT_DISTURB => ['class' => 'text-danger', 'name' => 'Do not disturb'],
        User::STATUS_INVISIBLE => ['class' => 'text-light', 'name' => 'Invisible'],
    ];

    public ?array $options;

    public string $accordionSelected = 'personalinfo';

    public $listeners = ['upload:finished' => 'updateProfilePhoto'];

    public function mount()
    {
        $this->options = auth()->user()->options;
    }

    public function render()
    {
        return view('chat.partials.leftsidebar.tabpane-settings');
    }

    public function updateProfilePhoto($name, $filenames)
    {
        $input = $this->validateOnly('photo', [
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        if (isset($input['photo'])) {
            auth()->user()->updateProfilePhoto($input['photo']);
        }
    }

    public function setUserStatus($value)
    {
        auth()->user()->status = $value;
        auth()->user()->push();
    }

    public function setTheme()
    {
        $this->accordionSelected = 'collapsethemes';
        auth()->user()->options = $this->options;
        auth()->user()->push();
    }
}
