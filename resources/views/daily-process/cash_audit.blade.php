<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Auditoria de Arqueo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
             <livewire:daily-process.cash-consilations.cash-audit> 
            </div>
        </div>
    </div>
</x-app-layout>