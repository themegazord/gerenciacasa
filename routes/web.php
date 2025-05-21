<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Views;

Route::get('/', Views\Home::class)->name('home');
Route::get('login', Views\Autenticacao\Login::class)->name('login');
Route::middleware('auth')->group(function () {
  Route::get('dashboard', Views\Dashboard::class)->name('dashboard');
});
