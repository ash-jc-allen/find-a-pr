<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head/>
<body class="antialiased text-gray-600 dark:text-gray-100 bg-gray-100 dark:bg-slate-700"
        x-data="{
            isDark: false,
            toggleDarkMode(enabled) {
                this.isDark = enabled;
                document.documentElement.classList.toggle('dark', enabled)
                localStorage.setItem('theme', enabled ? 'dark' : 'light');
            },
            shouldUseDarkMode() {
                const theme = localStorage.getItem('theme');

                return theme === 'dark'
                    || (theme === null && window.matchMedia('(prefers-color-scheme: dark)').matches);
            },
            darkModeIcon() {
                return this.isDark ? '☀️' : '🌙';
            }
        }"
        x-init="shouldUseDarkMode() ? toggleDarkMode(true) : toggleDarkMode(false)"
>
<div class="max-w-6xl mx-auto py-3" x-cloak>
    <div class="w-full p-4 sm:p-0 mx-auto mt-0 sm:mt-12">
        <x-header/>

        @livewire('list-issues')

        <x-footer/>
    </div>
</div>

@livewireScripts
</body>
</html>
