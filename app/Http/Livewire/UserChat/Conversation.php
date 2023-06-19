<?php

namespace App\Http\Livewire\UserChat;

use App\Events\NewMessage;
use App\Http\Livewire\Traits\LeftSidebarTrait;
use App\Models\Message;
use App\Models\Room;
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

    protected $listeners = [
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

    public function refreshMessages2($messageId, $roomId)
    {
        if ($this->room->id != $roomId) {
            return;
        }

        $message = Message::withTrashed()->find($messageId);
        $this->messages = $this->messages->merge(new Collection([$message]));
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
