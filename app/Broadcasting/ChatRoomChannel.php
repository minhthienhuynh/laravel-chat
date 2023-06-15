<?php

namespace App\Broadcasting;

use App\Models\User;

class ChatRoomChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, $roomId): bool|array
    {
        if ($user->canJoinRoom($roomId)) {
            return $user->only('id', 'name');
        }

        return false;
    }
}
