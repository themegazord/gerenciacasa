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
      Route::get('/cadastro', Views\Financas\Bancos\Cadastro::class)->name('financas.bancos.cadastro');
      Route::get('/edicao/{id}', Views\Financas\Bancos\Edicao::class)->name('financas.bancos.edicao');
    });
    Route::prefix('receitas')->group(function () {
      Route::get('/', Views\Financas\Receitas\Listagem::class)->name('financas.receitas.listagem');
      Route::get('/cadastro', Views\Financas\Receitas\Cadastro::class)->name('financas.receitas.cadastro');
    });
    Route::prefix('categorias')->group(function () {
      Route::get('/', Views\Financas\Categorias\Listagem::class)->name('financas.categorias.listagem');
      Route::get('/cadastro', Views\Financas\Categorias\Cadastro::class)->name('financas.categorias.cadastro');
      Route::get('/edicao/{id}', Views\Financas\Categorias\Edicao::class)->name('financas.categorias.edicao');
    });
  });
});
