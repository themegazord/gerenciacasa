@php
  $tiposCategorias = [
  ['tipo' => 'receita', 'label' => 'Receitas'],
  ['tipo' => 'despesa', 'label' => 'Despesas'],
  ];
@endphp
<div class="p-4 md:p-6">
  <p class="text-2xl font-bold mb-6">Categorias</p>
  <div class="flex flex-col md:flex-row md:items-end gap-4 mt-4 mb-8">
    <div class="flex-3">
      <x-input label="Nome da categoria" placeholder="Insira o nome da categoria que deseje consultar..." wire:model.live.debounce="pesquisa" inline />
    </div>
    <div class="flex-2">
      <x-select label="Tipo da categoria" placeholder="Escolha o tipo..." wire:model.live.debounce="pesquisaTipo" :options="$tiposCategorias" option-value="tipo" inline option-label="label" inline />
    </div>
    <div class="flex-1">
      <x-toggle label="Ativo?" wire:model.live.debounce="pesquisaAtivo" />
    </div>
    <div class="flex-1">
      <x-button label="Cadastrar" icon="o-plus" class="w-full md:w-auto btn btn-success" wire:loading.attr="disabled" link="{{ route('financas.categorias.cadastro') }}" />
    </div>
  </div>
</div>
