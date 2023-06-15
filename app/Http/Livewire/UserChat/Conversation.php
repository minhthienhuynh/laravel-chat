<?php

namespace App\Http\Livewire\UserChat;

use App\Events\NewMessage;
use App\Models\Room;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Conversation extends Component
{
    public Room $room;
    public Collection $messages;

    protected $listeners = [
        'messageSent' => 'refreshMessages',
        'messageReceived' => 'refreshMessages2',
    ];

    public function mount()
    {
        $this->messages = $this->getMessages();
    }

    public function render()
    {
        return view('chat.partials.user-chat.conversation');
    }

    public function refreshMessages(Message $message)
    {
        $this->messages->push($message);
    }

    public function refreshMessages2($messageId, $roomId)
    {
        if ($this->room->id != $roomId) {
            return;
        }

        $message = Message::withTrashed()->find($messageId);

        $this->messages = $this->messages->merge(new Collection([$message]));
    }

    public function deleteMessage(Message $message)
    {
        $message->delete();

        $this->messages = $this->messages->merge(new Collection([$message]));

        broadcast(new NewMessage($message))->toOthers();
    }

    protected function getMessages()
    {
        return $this->room->messages()
            ->latest()
            ->withTrashed()
            ->simplePaginate(15)
            ->getCollection()
            ->reverse();
    }
}
