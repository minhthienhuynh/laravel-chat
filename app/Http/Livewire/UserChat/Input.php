<?php

namespace App\Http\Livewire\UserChat;

use App\Events\MessageSent;
use App\Models\Group;
use App\Models\Message;
use Livewire\Component;

class Input extends Component
{
    public Group $group;
    public string $content = '';

    protected array $rules = [
        'content' => 'required|string',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('chat.partials.user-chat.input-form');
    }

    public function sendMessage()
    {
        try {
            $this->validate();

            $message = Message::create([
                'content'  => $this->content,
                'group_id' => $this->group->id,
                'user_id'  => auth()->id(),
            ]);

            $this->emitTo('user-chat.conversation-list', 'messageSent', $message->id);
            $this->reset('content');

            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }
    }
}
