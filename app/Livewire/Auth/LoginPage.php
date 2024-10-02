<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Title("ورود")]
class LoginPage extends Component
{
    #[Validate(["required"])]
    public $username = "";

    #[Validate(["required"])]
    public $password = "";

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

    /**
     * Dispatch a toast success event.
     */
    public function login()
    {
        // Validate the input fields (username, password)
        $this->validate();

        // Find the user by username
        $user = User::where("username", $this->username)->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($this->password, $user->password)) {
            // Reset any error messages
            $this->resetErrorBag();

            // Log the user in and remember them
            Auth::loginUsingId($user->id, true);

            // Set a success message in the session
            session()->flash('toast-success', [
                "title" => 'سوئیفت چت',
                "message" => 'با موفقیت وارد حساب کاربری خود شدید.',
            ]);

            // Redirect the user to the home page
            // $this->redirectRoute("home.page", navigate: true);
        } else {
            // Add an error message if login fails
            $this->addError('password', "نام کاربری یا کلمه عبور اشتباه می باشد.");
            return;
        }
    }
}
