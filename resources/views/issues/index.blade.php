<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>findapr.io - Find Your First Laravel PR</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description"
        content="View a curated list of issues so that you can make your very first contribution to open-source Laravel and PHP projects.">
    <link rel="canonical" href="https://findapr.io">

    <meta property="og:title" content="findapr.io - Find Your First Laravel PR" />
    <meta property="og:url" content="https://findapr.io" />
    <meta property="og:type" content="website" />
    <meta property="og:description"
        content="View a curated list of issues so that you can make your very first contribution to open-source Laravel and PHP projects." />
    <meta property="og:image" content="{{ config('app.url') . '/images/open-graph.png' }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@AshAllenDesign" />
    <meta name="twitter:creator" content="@AshAllenDesign" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {}
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

    </style>

    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://cdn.usefathom.com/script.js" data-site="CAHVPBCM" defer></script>
    <!-- / Fathom -->
</head>

<body class="antialiased text-gray-600 bg-gray-100 dark:bg-red-600" x-data="app()" x-init="init()">
    <div class="max-w-6xl mx-auto py-3">
        <div class="w-full sm:w-3/4 p-4 sm:p-0 mx-auto mt-0 sm:mt-12">
            <div class="flex flex-col sm:flex-row gap-2 justify-between item-center">
                <img class="w-48" src="/images/findapr.svg" alt="findapr.io logo">
                <div class="flex space-x-3 items-center">
                    <a href="#" x-show="!isDark" @click.prevent="toggleMode()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </a>

                    <a href="#" x-show="isDark" @click.prevent="toggleMode()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z" />
                        </svg>
                    </a>


                    <a href="https://github.com/ash-jc-allen/find-a-pr"
                        class="flex justify-center items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 dark:bg-green-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <img src="/images/github-logo.png" class="w-6 pr-2 inline" alt="View on GitHub" />
                        View on GitHub
                    </a>
                </div>
            </div>

            <div class="mt-12">
                <p class="text-right">
                    Found <span class="font-bold">{{ count($issues) }}</span> issue(s)
                </p>

                @foreach ($issues as $issue)
                    <div class="border p-4 sm:py-5 sm:px-8 my-4 rounded-lg shadow bg-white">
                        <div class="flex flex-col sm:flex-row justify-start sm:justify-between items-start gap-2">
                            <div class="w-full md:w-3/4">
                                <a href="{{ $issue->url }}"
                                    class="text-xl font-bold inline-block">{{ $issue->title }}</a>
                                <div>
                                    <a href="{{ $issue->repoUrl }}"
                                        class="text-gray-400">{{ $issue->repoName }}</a>
                                </div>
                            </div>
                            <div>
                                <a href="{{ $issue->url }}"
                                    class="w-full inline-block px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-400 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">View
                                    Issue</a>
                            </div>
                        </div>

                        <div class="my-2">
                            @foreach ($issue->labels as $label)
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border bg-opacity-20"
                                    style="color: {{ $label->color }}; border-color: {{ $label->color }}; background-color: {{ $label->color . '30' }}">
                                    {{ $label->name }}
                                </span>
                            @endforeach
                        </div>

                        <p class="my-4">
                            {{ str($issue->body)->limit(150) }}
                        </p>

                        <div class="flex flex-col sm:flex-row gap-2 justify-between items-start sm:items-center">
                            <a href="{{ $issue->createdBy->url }}"
                                class="border hover:bg-gray-100 inline-block p-2 rounded">
                                <img src="{{ $issue->createdBy->profilePictureUrl }}"
                                    class="inline-block h-6 w-6 rounded-full" alt="{{ $issue->createdBy->name }}">
                                <p class="inline">{{ $issue->createdBy->name }}</p>
                            </a>

                            <p class="text-sm text-gray-400">{{ $issue->createdAt->format('jS M Y @ H:i') }}</p>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="https://ashallendesign.co.uk"
                    class="bg-gray-200 hover:bg-gray-300 rounded shadow inline-block px-5 py-2 my-12 mx-auto">
                    🚀 Powered by <span class="font-bold">Ash Allen Design</span>
                </a>
            </div>
        </div>
    </div>
    <script>
        function app() {
            return {
                init() {
                    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                            '(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark')
                        this.isDark = true;
                    } else {
                        document.documentElement.classList.remove('dark')
                        this.isDark = false;
                    }
                },
                toggleMode() {
                    if (localStorage.theme === 'dark') {
                        document.documentElement.classList.remove('dark')
                        this.isDark = false;
                        localStorage.theme = 'light'
                    } else {
                        document.documentElement.classList.add('dark')
                        localStorage.theme = 'dark'
                        this.isDark = true;
                    }
                },
            }
        }
    </script>
</body>

</html>
