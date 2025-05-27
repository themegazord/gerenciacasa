@php
  $tiposCategorias = [
    ['id' => 'receitas', 'name' => 'Receitas'],
    ['id' => 'despesas', 'name' => 'Despesas'],
  ];
@endphp
<div class="p-4 md:p-6">
  <div class="font-semibold text-xl">Categorias</div>

  <div class="flex flex-col md:flex-row md:items-end gap-4 mt-4 mb-8">
    <div class="flex-3">
      <x-input label="Nome da categoria" placeholder="Insira o nome da categoria que deseje consultar..." wire:model.live.debounce="pesquisa" inline/>
    </div>
    <div class="flex-2">
      <x-select label="Tipo da categoria" placeholder="Escolha o tipo..." placeholder-value="{{ null }}" wire:model.live.debounce="pesquisaTipo" :options="$tiposCategorias" inline/>
    </div>
    <div class="flex-1">
      <x-toggle label="Ativo?" wire:model.change="pesquisaAtivo"/>
    </div>
    <div class="flex-1">
      <x-button label="Cadastrar" icon="o-plus" class="w-full md:w-auto btn btn-success"/>
    </div>
  </div>


</div>
