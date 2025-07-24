<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>

  {{-- Currency  --}}
  <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
  {{-- Flatpickr  --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>

  <script>
    flatpickr.localize(flatpickr.l10ns.pt);
  </script>
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">

  <x-nav sticky class="lg:hidden">
    <x-slot:brand>
      <x-app-brand />
    </x-slot:brand>
    <x-slot:actions>
      <label for="main-drawer" class="lg:hidden me-3">
        <x-icon name="o-bars-3" class="cursor-pointer" />
      </label>
    </x-slot:actions>
  </x-nav>

  {{-- MAIN --}}
  <x-main>
    {{-- SIDEBAR --}}
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

      {{-- BRAND --}}
      <x-app-brand class="px-5 pt-4" />

      {{-- MENU --}}
      <x-menu activate-by-route>

        {{-- User --}}
        @if ($user = auth()->user())
        <x-menu-separator />

        <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
          class="-mx-2 !-my-2 rounded">
          <x-slot:actions>
            <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate
              link="/logout" />
          </x-slot:actions>
        </x-list-item>

        <x-menu-separator />
        @endif

        {{-- Main Sections --}}
        <x-menu-item title="Início" icon="o-home" link="{{ route('dashboard') }}" />

        {{-- Finanças --}}
        <x-menu-sub title="Finanças" icon="o-currency-dollar">
          <x-menu-item title="Receitas" icon="o-arrow-up-circle" link="{{ route('financas.receitas.listagem') }}" />
          <x-menu-item title="Despesas" icon="o-arrow-down-circle" link="{{ route('financas.despesas.listagem') }}" />
          <x-menu-item title="Categorias" icon="o-tag" link="{{ route('financas.categorias.listagem') }}" />
          <x-menu-item title="Contas Bancárias" icon="o-banknotes" link="{{ route('financas.bancos.listagem') }}" />
          <x-menu-sub title="Baixas" icon="o-document-currency-dollar">
            <x-menu-item title="Receitas" icon="o-arrow-up-circle" link="{{ route('financas.baixas.receitas.listagem') }}" />
            <x-menu-item title="Despesas" icon="o-arrow-down-circle" link="{{ route('financas.baixas.despesas.listagem') }}" />
          </x-menu-sub>
        </x-menu-sub>


        {{-- Relatórios --}}
        <x-menu-sub title="Relatórios" icon="o-chart-bar">
          <x-menu-item title="Resumo Mensal" icon="o-calendar" link="/relatorios/resumo-mensal" />
          <x-menu-item title="Comparativo Mensal" icon="o-presentation-chart-line" link="/relatorios/comparativo-mensal" />
          <x-menu-item title="Distribuição por Categoria" icon="o-chart-pie"
            link="/relatorios/distribuicao-categoria" />
        </x-menu-sub>

        {{-- Família / Membros --}}
        <x-menu-sub title="Família / Membros" icon="o-users">
          <x-menu-item title="Usuários / Moradores" icon="o-user-circle" link="/usuarios" />
          <x-menu-item title="Divisão de Despesas" icon="o-scale" link="/divisao-despesas" />
        </x-menu-sub>

        {{-- Importação / Integração --}}
        <x-menu-sub title="Importação / Integração" icon="o-cloud">
          <x-menu-item title="Importar Extrato OFX" icon="o-document" link="/importar/ofx" />
        </x-menu-sub>

        {{-- Configurações --}}
        <x-menu-sub title="Configurações" icon="o-cog">
          <x-menu-item title="Perfil do Usuário" icon="o-user" link="/perfil" />
          <x-menu-item title="Preferências do Sistema" icon="o-adjustments-horizontal" link="/preferencias" />
        </x-menu-sub>

        {{-- Extras --}}
        <x-menu-sub title="Extras" icon="o-light-bulb">
          <x-menu-item title="Tarefas / Lista de Compras" icon="o-check-circle" link="/tarefas" />
          <x-menu-item title="Calendário Financeiro" icon="o-calendar-days" link="/calendario" />
          <x-menu-item title="Metas e Planejamento" icon="o-flag" link="/metas" />
        </x-menu-sub>

      </x-menu>
    </x-slot:sidebar>

    {{-- The `$slot` goes here --}}
    <x-slot:content>
      {{ $slot }}
    </x-slot:content>
  </x-main>
  {{-- TOAST area --}}
  <x-toast />
</body>

</html>
