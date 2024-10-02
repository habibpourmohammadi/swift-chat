<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title("ثبت نام")]
class RegisterPage extends Component
{
    #[Validate(["required", "max:140"])]
    public $first_name = "";

    #[Validate(["required", "max:140"])]
    public $last_name = "";

    #[Validate(["required", "numeric", 'regex:/^(\+98|0|98|9)?9[0-9]{9}$/', "unique:users,mobile"])]
    public $mobile = "";

    #[Validate(["required", "alpha", "unique:users,username", "max:35"])]
    public $username = "";

    #[Validate(["required", "min:8"])]
    public $password = "";

    /**
     * Handle user registration.
     */
    public function register()
    {
        // Validate the inputs
        $this->validate();

        // Create the user with a hashed password
        $user = User::create([
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "mobile" => $this->mobile,
            "username" => $this->username,
            "password" => $this->password,
        ]);

        // Redirect to login page with a success message
        // $this->redirectRoute("login", navigate: true);
    }
}
