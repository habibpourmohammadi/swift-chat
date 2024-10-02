<?php

use App\Livewire\Auth\RegisterPage;
use Illuminate\Support\Facades\Route;

Route::get("register", RegisterPage::class)->middleware("guest")->name("auth.register.page");
