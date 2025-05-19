<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Views;

Route::get('/', Views\Home::class)->name('home');
Route::get('login', Views\Autenticacao\Login::class)->name('login');
