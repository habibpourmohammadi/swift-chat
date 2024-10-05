<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Home\ChatPage;
use App\Livewire\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get("register", RegisterPage::class)->middleware("guest")->name("auth.register.page");
Route::get("login", LoginPage::class)->middleware("guest")->name("auth.login.page");

Route::middleware("auth")->group(function () {
    Route::get("/", HomePage::class)->name("home.page");
    Route::get("/chat/{chat:chat_uuid}", ChatPage::class)->name("home.chat.page");
});
