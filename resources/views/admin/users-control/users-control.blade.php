<x-app-layout>
    @include('sweetalert::alert')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            <i class="fa-solid fa-users"></i> {{ __('Control de usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
             <livewire:admin.users-control.users-control/>
            </div>
        </div>
    </div>
</x-app-layout>
