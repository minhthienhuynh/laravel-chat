<?php

namespace App\Http\Livewire\UserChat;

use App\Events\NewMessage;
use App\Http\Livewire\Traits\LeftSidebarTrait;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Livewire\Component;

class Conversation extends Component
{
    use LeftSidebarTrait;

    public Room $room;
    public Collection $messages;
    public int $perPage = 50;
    public int $page = 1;
    public ?int $lastItemId = null;
    public bool $hasMore = false;
    public array $usersTyping = [];

    protected $listeners = [
        'messageTyping' => 'setUsersTyping',
        'messageSent' => 'refreshMessages',
        'messageReceived' => 'refreshMessages2',
    ];

    public function mount()
    {
        $this->messages = $this->getMessages();

        if (! $this->messages->isEmpty()) {
            $this->lastItemId = $this->messages->last()->id;
        }
    }

    public function render()
    {
        return view('chat.partials.user-chat.conversation');
    }

    public function refreshMessages(Message $message)
    {
        $this->messages->push($message);
        $this->makeUnreadFrom($message);
        $this->emit('scrollToBottom');
    }

    public function setUsersTyping(Room $room, User $user)
    {
        if ($this->room->id == $room->id) {
            $this->usersTyping[$user->id] = $user;
        } else {
            $this->resetUsersTyping();
        }
    }

    public function refreshMessages2($messageId, $roomId)
    {
        if ($this->room->id != $roomId) {
            return;
        }

        $message = Message::withTrashed()->find($messageId);

        $this->resetUsersTyping();

        $this->messages = $this->messages->merge(new Collection([$message]));
    }

    public function resetUsersTyping(int $userId = null)
    {
        if (isset($userId)) {
            unset($this->usersTyping[$userId]);
        } else {
            $this->reset('usersTyping');
        }
    }

    public function makeUnreadFrom(Message $message)
    {
        $this->room->users()->updateExistingPivot(auth()->id(), [
            'unread_from_message_id' => $message->id
        ]);

        $this->updateChatTabPane($this->room);
    }

    public function deleteMessage(Message $message)
    {
        $message->delete();

        $this->messages = $this->messages->merge(new Collection([$message]));

        broadcast(new NewMessage($message))->toOthers();
    }

    public function loadMore()
    {
        $this->page++;

        $messages = $this->getMessages();

        $this->emit('scrollToMessage', $this->messages->first()->id, [
            'behavior' => 'instant',
            'block' => 'start',
            'inline' => 'nearest'
        ]);

        $this->messages = $messages->merge($this->messages);
    }

    protected function getMessages()
    {
        /** @var Paginator $paginator */
        $paginator = $this->room->messages()
            ->when(isset($this->lastItemId), fn (Builder $query) => $query->where('id', '<=', $this->lastItemId))
            ->latest()
            ->withTrashed()
            ->simplePaginate($this->perPage, ['*'], 'page', $this->page);

        $this->hasMore = $paginator->hasMorePages();

        return $paginator->getCollection()->reverse();
    }
}
