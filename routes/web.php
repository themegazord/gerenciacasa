<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Views;

Route::get('/', Views\Home::class)->name('home');
