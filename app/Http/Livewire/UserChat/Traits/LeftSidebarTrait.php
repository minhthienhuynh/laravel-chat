<?php

namespace App\Http\Livewire\UserChat\Traits;

use App\Models\Room;

trait LeftSidebarTrait
{
    protected function updateLeftSidebar(Room $room): void
    {
        if ($room->isFavourite()) {
            $this->emitTo('left-sidebar.chats.favourites', 'needRerender');
        } elseif ($room->isUserType()) {
            $this->emitTo('left-sidebar.chats.direct-messages', 'needRerender');
        } elseif ($room->isGroupType()) {
            $this->emitTo('left-sidebar.chats.channels', 'needRerender');
        }
    }
}
