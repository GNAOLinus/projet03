<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Banque des mémoires de ESM') }}
        </h2>
    </x-slot>
    @yield('content')
</x-app-layout>
