@php
$configuracaoDatetime = ['altFormat' => 'd/m/Y'];

$bancos = auth()->user()->bancos;
@endphp
<div class="p-4 md:p-6">
  <p class="font-bold text-2xl">Cadastro de baixa das receitas</p>
  <x-form wire:submit.prevent="cadastrar">
    <x-choices
      label="Receita"
      wire:model="baixa.receita_id"
      :options="$receitas" single required>
      @scope('item', $receita)
      <x-list-item :item="$receita">
        <x-slot:value>#{{ $receita->id }} - {{ \Carbon\Carbon::parse($receita->data)->format('d/m/Y') }} - {{ $receita->descricao }}</x-slot:value>
        <x-slot:sub-value>R$ {{ number_format($receita->valor_aberto, 2, ',', '.') }}</x-slot:sub-value>
      </x-list-item>
      @endscope

      @scope('selection', $receita)
      #{{ $receita->id }} {{ $receita->descricao }} -> (R$ {{ number_format($receita->valor_aberto, 2, ',', '.') }})
      @endscope
    </x-choices>
    <div class="flex flex-col gap-4 md:flex-row">
      <div class="flex-1">
        <x-input label="Descrição" wire:model="baixa.descricao" placeholder="Informe a descrição da baixa..." required />
      </div>
      <div class="flex-1">
        <x-choices
          label="Banco"
          wire:model="baixa.banco_id"
          placeholder="Selecione o banco..."
          :options="$bancos" single required>
          @scope('item', $banco)
          <x-list-item :item="$banco">
            <x-slot:value>{{ $banco->nome }} - R$ {{ number_format($banco->saldo_atual, 2, ',', '.') }}</x-slot:value>
          </x-list-item>
          @endscope

          @scope('selection', $banco)
          {{ $banco->nome }} - R$ {{ number_format($banco->saldo_atual, 2, ',', '.') }}
          @endscope
        </x-choices>
      </div>
    </div>

    <div class="flex flex-col gap-4 md:flex-row">
      <div class="flex-1">
        <x-select label="Forma de pagamento" wire:model="baixa.forma_pagamento" placeholder="Selecione a forma de pagamento..." :options="auth()->user()->formasPagamento()" required />
      </div>
      <div class="flex-1">
        <x-datepicker label="Data do recebimento" wire:model="baixa.data_baixa" icon="o-calendar" :config="$configuracaoDatetime" required />
      </div>
      <div class="flex-1">
        <x-input label="Valor" wire:model="baixa.valor" prefix="R$" locale="pt-BR" money required />
      </div>
    </div>

    <x-textarea label="Observações" rows="5" wire:model="baixa.observacoes" />

    <x-slot:actions>
      <x-button label="Voltar" link="{{ route('financas.baixas.receitas.listagem') }}" class="btn btn-error" />
      <x-button label="Cadastrar" wire:click="cadastrar" wire:loading.attr="disabled" spinner="cadastrar" class="btn btn-success" />
    </x-slot:actions>
  </x-form>
</div>
