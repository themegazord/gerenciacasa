<?php

namespace App\Providers;

use App\Models\DespesaBaixa;
use App\Models\ReceitaBaixa;
use App\Observers\DespesaBaixaObserver;
use App\Observers\ReceitaBaixaObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    ReceitaBaixa::observe(ReceitaBaixaObserver::class);
    DespesaBaixa::observe(DespesaBaixaObserver::class);
  }
}
