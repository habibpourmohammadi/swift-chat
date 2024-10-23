<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class HomePage extends Component
{
    public $search = "";

    /**
     * Handle the component mount event.
     */
    public function mount()
    {
        if (session('toast-success')) {
            $this->dispatch("dispatch-toast", eventName: 'toast-success', eventTitle: session('toast-success')["title"], eventMessage: session('toast-success')["message"]);
        }
    }

    /**
     * Dispatch a toast success event.
     */
    #[On("dispatch-toast")]
    public function dispatchToastSuccess($eventName, $eventTitle, $eventMessage)
    {
        $this->dispatch($eventName, title: $eventTitle, message: $eventMessage);
    }

    #[On("update-chat-list")]
    #[Computed()]
    public function chats()
    {
        // Return the authenticated user's chats
        return Auth::user()->chats($this->search);
    }
}
