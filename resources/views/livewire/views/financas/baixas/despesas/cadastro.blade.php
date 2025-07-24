@php
  $configuracaoDatetime = ['altFormat' => 'd/m/Y'];

  $bancos = auth()->user()->bancos;
@endphp
<div class="p-4 md:p-6">
  <p class="font-bold text-2xl">Cadastro de baixa de despesas</p>
  <x-form wire:submit.prevent="cadastrar">
    <x-choices
      label="Despesa"
      wire:model="baixa.despesa_id"
      :options="$despesas" single required>
      @scope('item', $despesa)
      <x-list-item :item="$despesa">
        <x-slot:value>#{{ $despesa->id }} - {{ \Carbon\Carbon::parse($despesa->data_vencimento)->format('d/m/Y') }} - {{ $despesa->descricao }}</x-slot:value>
        <x-slot:sub-value>R$ {{ number_format($despesa->valor_aberto, 2, ',', '.') }}</x-slot:sub-value>
      </x-list-item>
      @endscope

      @scope('selection', $despesa)
      #{{ $despesa->id }} {{ $despesa->descricao }} -> (R$ {{ number_format($despesa->valor_aberto, 2, ',', '.') }})
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
        <x-datepicker label="Data do pagamento" wire:model="baixa.data_baixa" icon="o-calendar" :config="$configuracaoDatetime" required />
      </div>
      <div class="flex-1">
        <x-input label="Valor" wire:model="baixa.valor" prefix="R$" locale="pt-BR" money required />
      </div>
    </div>

    <x-textarea label="Observações" rows="5" wire:model="baixa.observacoes" />

    <x-slot:actions>
      <x-button label="Voltar" link="{{ route('financas.baixas.despesas.listagem') }}" class="btn btn-error" />
      <x-button label="Cadastrar" wire:click="cadastrar" wire:loading.attr="disabled" spinner="cadastrar" class="btn btn-success" />
    </x-slot:actions>
  </x-form>
</div>
