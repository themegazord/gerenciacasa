<?php

namespace App\Livewire\Views;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class NotFound extends Component
{
  #[Title('Página não encontrada')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return <<<'HTML'
          <div class="flex items-center justify-center h-screen">
            <div class="flex flex-col">
              <h1 class="text-6xl font-bold text-red-500">404</h1>
              <p class="text-xl mt-4 text-gray-700">Ops! Página não encontrada.</p>
              <p class="text-gray-500 mt-2">A página que você está procurando não existe ou foi movida.</p>
              <x-button label="Voltar para o início" link="{{ route('dashboard') }}" class="mt-6  btn btn-primary"/>
            </div>
          </div>
        HTML;
  }
}
