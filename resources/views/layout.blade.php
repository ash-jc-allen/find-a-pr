<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>findapr.io - Find Your First Laravel PR</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="View a curated list of issues so that you can make your very first contribution to open-source Laravel and PHP projects.">
    <link rel="canonical" href="https://findapr.io">

    <meta property="og:title" content="findapr.io - Find Your First Laravel PR"/>
    <meta property="og:url" content="https://findapr.io"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description" content="View a curated list of issues so that you can make your very first contribution to open-source Laravel and PHP projects."/>
    <meta property="og:image" content="{{ config('app.url').'/images/open-graph.png' }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@AshAllenDesign"/>
    <meta name="twitter:creator" content="@AshAllenDesign"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://cdn.usefathom.com/script.js" data-site="CAHVPBCM" defer></script>
    <!-- / Fathom -->
</head>
<body class="antialiased text-gray-600 dark:text-gray-400 bg-gray-100 dar:bg-gray-700">
    <div class="max-w-6xl mx-auto py-10 sm:px-4">

            <header class="flex flex-col sm:flex-row sm:justify-between items-center">
                <img class="w-48 mb-4 sm:mb-0" src="/images/findapr.svg" alt="findapr.io logo">
                <a href="https://github.com/ash-jc-allen/find-a-pr"
                   class="flex items-center max-w-xs ma px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <img src="/images/github-logo.png" class="w-6 pr-2 inline">
                    View on GitHub
                </a>
            </header>

            @yield('content')

            <footer class="text-center">
                <a href="https://ashallendesign.co.uk" class="bg-gray-200 hover:bg-gray-300 rounded shadow inline-block px-5 py-2 my-12 mx-auto">
                    🚀 Powered by <span class="font-bold">Ash Allen Design</span>
                </a>
            </footer>
        </div>

</body>
</html>
