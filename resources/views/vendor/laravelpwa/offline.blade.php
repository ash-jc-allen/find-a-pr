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
    <div class="antialiased text-gray-600 dark:text-gray-100 bg-gray-100 dark:bg-slate-700">
        <div class="max-w-6xl mx-auto w-full h-screen p-4 flex flex-col text-center items-center justify-center">
            <img class="w-48 dark:hidden" src="{{ asset('images/findapr.svg') }}" alt="findapr.io logo - light mode">
            <img class="w-48 hidden dark:block" src="{{ asset('images/findapr-white.svg') }}" alt="findapr.io logo - dark mode">

            <p class="pt-4">You are currently offline!</p>
        </div>
    </div>
@livewireScripts
</body>
</html>
