<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SidebarMenu extends Component
{
    public ?array $options;

    public function mount()
    {
        $this->options = auth()->user()->options;
    }

    public function render()
    {
        return view('chat.partials.sidebar-menu');
    }

    public function setDarkMode()
    {
        $this->options['dark-mode'] = ! $this->options['dark-mode'];
        auth()->user()->options = $this->options;
        auth()->user()->push();
    }
}
