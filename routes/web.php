<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Views;

Route::get('/', Views\Home::class)->name('home');
Route::get('login', Views\Autenticacao\Login::class)->name('login');
Route::middleware('auth')->group(function () {
  Route::get('dashboard', Views\Dashboard::class)->name('dashboard');
  Route::prefix('financas')->group(function () {
    Route::prefix('bancos')->group(function () {
      Route::get('/', Views\Financas\Bancos\Listagem::class)->name('financas.bancos.listagem');
    });
  });
});
