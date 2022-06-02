<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head/>
<body class="antialiased text-gray-600 dark:text-gray-100 bg-gray-100 dark:bg-slate-700" x-data="app()" x-init="init()">
<div class="max-w-6xl mx-auto py-3">
    <div class="w-full p-4 sm:p-0 mx-auto mt-0 sm:mt-12">
        <x-header/>

        @livewire('list-issues')

        <x-footer/>
    </div>
</div>

@livewireScripts

<script>
    function app() {
        return {
            init() {
                if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                        '(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark')
                    this.isDark = true;
                    localStorage.theme = 'dark'
                } else {
                    document.documentElement.classList.remove('dark')
                    this.isDark = false;
                    localStorage.theme = 'light'
                }
            },
            toggleLightMode() {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
                this.isDark = false;
            },
            toggleDarkMode() {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
                this.isDark = true;
            }
        }
    }
</script>
</body>
</html>
