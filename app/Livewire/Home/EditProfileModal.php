<?php

namespace App\Livewire\Home;

use App\Events\UpdateProfile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Storage;

class EditProfileModal extends Component
{
    use WithFileUploads;

    public string $first_name = "";

    public string $last_name = "";

    public string $username = "";

    public $avatar;

    /**
     * Initialize the component with the user's current profile data.
     */
    public function mount()
    {
        $this->fill([
            "first_name" => Auth::user()->first_name,
            "last_name" => Auth::user()->last_name,
            "username" => Auth::user()->username,
        ]);
    }

    /**
     * Validate and update the user's profile.
     */
    public function updateProfile()
    {
        // Validate the user's input
        $this->validate([
            "first_name" => ["required", "max:140"],
            "last_name" => ["required", "max:140"],
            "username" => ["required", "alpha", "unique:users,username," . Auth::user()->id, "max:35"],
            "avatar" => ["nullable", "image", "mimes:png,jpg,jpeg", "max:1024"],
        ]);

        // Get the old username for comparison
        $old_username = Auth::user()->username;

        // Check if the current avatar is the default one
        $avatar = Auth::user()->avatar == Vite::asset("resources/images/avatar/default-avatar.jpg") ? null : str_replace('/storage/', '', Auth::user()->avatar);

        // Store the new avatar if it was uploaded
        if ($this->avatar) {
            $avatar = $this->avatar->store("avatars", "public");

            // Delete the old avatar if it wasn't the default one
            if (Auth::user()->avatar != Vite::asset("resources/images/avatar/default-avatar.jpg")) {
                Storage::disk("public")->delete(str_replace('/storage/', '', Auth::user()->avatar));
            }
        }

        // Update the user's profile in the database
        Auth::user()->update([
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "username" => $this->username,
            "avatar" => $avatar
        ]);

        // Broadcast the profile update to others
        broadcast(new UpdateProfile([
            "full_name" => Auth::user()->full_name,
            "username" => Auth::user()->username,
            "old_username" => $this->username == $old_username ? false : $old_username,
            "avatar" => asset(Auth::user()->avatar),
        ]))->toOthers();

        // Redirect the user to the home page
        $this->redirectRoute("home.page", navigate: true);
    }
}
