<?php

namespace App\Http\Livewire\UserChat;

use App\Events\NewMessage;
use App\Http\Livewire\UserChat\Traits\LeftSidebarTrait;
use App\Models\Room;
use App\Models\Message;
use Livewire\Component;

class Input extends Component
{
    use LeftSidebarTrait;

    public Room $room;
    public array $options = [];
    public string $content = '';

    protected $listeners = [
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

    public function replyMessage(Message $message)
    {
        $this->options['reply'] = $message->toArray();
        $this->emit('focusOnChatInput', true);
    }

    public function resetReplyMessage()
    {
        $this->reset('options');
    }

    public function sendMessage()
    {
        try {
            $this->validate();

            $message = $this->room->messages()->create([
                'content' => $this->content,
                'user_id' => auth()->id(),
                'options' => $this->options,
            ]);

            $this->emitTo('user-chat.conversation', 'messageSent', $message->id);
            $this->emit('focusOnChatInput', true);
            $this->reset('content', 'options');
            $this->updateLeftSidebar($this->room);

            broadcast(new NewMessage($message))->toOthers();
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }
    }
}
