<div class="min-h-screen flex flex-col">

  <section class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-6 py-16 text-center">
      <img src="{{ asset('logo.png') }}" alt="Logo do gerenciacasa" class="mx-auto h-40 mb-4">
      <p class="mt-4 text-lg text-gray-600">
        Controle financeiro simples e prático para sua casa, família ou república.
      </p>
      <div class="mt-8">
        <a href="#cadastro" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700 transition">Começar agora</a>
        <a href="/login" class="inline-block border border-indigo-600 text-indigo-600 px-6 py-3 rounded-full hover:bg-indigo-50 transition">Fazer login</a>
      </div>
    </div>
  </section>

  <section class="py-20">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-semibold mb-10">Recursos principais</h2>
      <div class="grid gap-10 md:grid-cols-3">
        <div>
          <div class="text-indigo-600 text-4xl mb-2">&#128200;</div>
          <h3 class="text-xl font-semibold">Controle de Despesas</h3>
          <p class="text-gray-600">Registre, categorize e acompanhe suas saídas com facilidade.</p>
        </div>
        <div>
          <div class="text-indigo-600 text-4xl mb-2">&#128178;</div>
          <h3 class="text-xl font-semibold">Orçamento Familiar</h3>
          <p class="text-gray-600">Defina limites e metas para evitar surpresas no fim do mês.</p>
        </div>
        <div>
          <div class="text-indigo-600 text-4xl mb-2">&#128202;</div>
          <h3 class="text-xl font-semibold">Relatórios Visuais</h3>
          <p class="text-gray-600">Gráficos intuitivos para entender melhor seus gastos e rendas.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-indigo-50 py-20" id="cadastro">
    <div class="max-w-md mx-auto px-6">
      <h2 class="text-2xl font-semibold text-center text-indigo-700 mb-6">Crie sua conta gratuita</h2>
      <x-form wire:submit.prevent="cadastrar" class="bg-primary shadow rounded p-6">
        <x-input label="Nome" wire:model="nome" type="text" required />
        <x-input label="Email" wire:model="email" type="email" required />
        <x-password label="Senha" wire:model="senha" required right/>
        <x-password label="Confirme sua senha" wire:model="confirmacao_senha" required right/>
        <x-button type="submit" class="btn btn-primary" label="Cadastrar" wire:loading.attr="disabled" spinner="cadastrar"/>
      </x-form>
    </div>
  </section>

  <footer class="text-center text-sm text-gray-500 py-6">
    &copy; {{ date('Y') }} Gerenciacasa. Todos os direitos reservados.
  </footer>

</div>
