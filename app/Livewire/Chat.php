<?php

namespace App\Livewire;

use App\Services\PropertyChatbot;
use Livewire\Component;

class Chat extends Component
{
    public bool $open = false;
    public array $messages = [];
    public string $input = '';

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function send(PropertyChatbot $bot): void
    {
        $text = trim($this->input);
        if ($text === '') {
            return;
        }

        // Auto-open panel if somehow closed
        $this->open = true;

        $this->messages[] = ['role' => 'user', 'content' => $text];
        $this->input = '';

        try {
            $reply = $bot->ask(array_slice($this->messages, -10));   // last 10 turns
        } catch (\Throwable $e) {
            report($e);
            $reply = 'Sorry, the assistant is unavailable right now.';
        }

        $this->messages[] = ['role' => 'assistant', 'content' => $reply];
    }

    public function clearHistory(): void
    {
        $this->messages = [];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.chat');
    }
}
