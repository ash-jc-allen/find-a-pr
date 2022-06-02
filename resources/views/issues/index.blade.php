<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head/>
<body class="antialiased text-gray-600 bg-gray-100">
<div class="max-w-6xl mx-auto py-3">
    <div class="w-full p-4 sm:p-0 mx-auto mt-0 sm:mt-12">
        <x-header/>

        @livewire('list-issues')

        <x-footer/>
    </div>
</div>

@livewireScripts
</body>
</html>
