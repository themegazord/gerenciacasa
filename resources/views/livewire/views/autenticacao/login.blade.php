<div class="flex items-center min-h-screen md:grid md:grid-cols-3">
  <div class="hidden md:flex justify-center items-center bg-white md:col-span-2 md:min-h-screen">
    <img src="{{ asset('logo.png') }}" alt="Logo do gerenciacasa" class="h-80">
  </div>
  <div class="flex flex-col md:flex-row w-full bg-gray-800 mx-8 md:mx-0 md:min-h-screen items-center p-6 rounded shadow-lg md:col-span-1">
    <img src="{{ asset('logo_cinza.png') }}" alt="Logo do gerenciacasa" class="h-80 my-[-6rem] md:hidden">
    <x-form wire:submit.prevent="login" class="w-full">
      <x-input label="Email" wire:model="email" />
      <x-password label="Senha" wire:model="senha" right />
      <x-slot:actions>
        <x-button label="Entrar" />
      </x-slot:actions>
    </x-form>
  </div>
</div>
