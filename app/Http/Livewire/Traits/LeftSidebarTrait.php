<?php

namespace App\Http\Livewire\Traits;

use App\Models\Room;

trait LeftSidebarTrait
{
    protected function updateChatTabPane(Room $room, $favoriteUpdated = false): void
    {
        if ($favoriteUpdated) {
            $this->emitTo('left-sidebar.tabpane-chats.favourites', 'needRerender');

            if ($room->isUserType()) {
                $this->emitTo('left-sidebar.tabpane-chats.direct-messages', 'needRerender');
            } else {
                $this->emitTo('left-sidebar.tabpane-chats.channels', 'needRerender');
            }
        } elseif ($room->isFavourite()) {
            $this->emitTo('left-sidebar.tabpane-chats.favourites', 'needRerender');
        } elseif ($room->isUserType()) {
            $this->emitTo('left-sidebar.tabpane-chats.direct-messages', 'needRerender');
        } else {
            $this->emitTo('left-sidebar.tabpane-chats.channels', 'needRerender');
        }
    }
}
