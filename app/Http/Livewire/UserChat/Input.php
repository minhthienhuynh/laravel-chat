<?php

namespace App\Http\Livewire\UserChat;

use App\Events\MessageSent;
use App\Models\Group;
use App\Models\Message;
use Livewire\Component;

class Input extends Component
{
    public ?Group $group;
    public ?array $options = [];
    public string $content = '';

    protected $listeners = [
        'contactSelected' => 'renderInput',
        'messageReplying' => 'replyMessage',
    ];

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

    public function renderInput(Group $group)
    {
        $this->group = $group;

        if ($group->type == Group::TYPE_USER) {
            $this->user = $group->other_users->first();
        } else {
            $this->user = null;
        }

        $this->reset('content', 'options');
    }

    public function replyMessage(Message $message)
    {
        $this->options['reply'] = $message->toArray();
    }

    public function resetReplyMessage()
    {
        $this->reset('options');
    }

    public function sendMessage()
    {
        try {
            $this->validate();

            $message = Message::create([
                'content' => $this->content,
                'group_id' => $this->group->id,
                'user_id' => auth()->id(),
                'options' => $this->options,
            ]);

            $this->emitTo('user-chat.conversation', 'messageSent', $message->id);
            $this->reset('content', 'options');

            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }
    }
}
