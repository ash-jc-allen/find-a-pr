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

@yield('content')

@livewireScripts
</body>
</html>
