<?php

namespace App\Http\Livewire\UserChat;

use App\Events\MessageSent;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Conversation extends Component
{
    public ?Group $group;
    public Collection $messages;

    protected $listeners = [
        'contactSelected' => 'renderMessages',
        'messageSent' => 'refreshMessages',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.conversation');
    }

    public function renderMessages(Group $group)
    {
        $this->group = $group;
        $this->messages = $this->getMessages();
    }

    public function refreshMessages(Message $message)
    {
        $this->messages->push($message);
    }

    public function messageReceived($messageId)
    {
        $message = Message::withTrashed()->find($messageId);

        $this->messages = $this->messages->merge(new Collection([$message]));
    }

    public function deleteMessage(Message $message)
    {
        $message->delete();

        $this->messages = $this->messages->merge(new Collection([$message]));

        broadcast(new MessageSent($message))->toOthers();
    }

    protected function getMessages()
    {
        return $this->group->messages()
            ->latest()
            ->withTrashed()
            ->simplePaginate(10)
            ->getCollection()
            ->reverse();
    }
}
