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

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://cdn.usefathom.com/script.js" data-site="CAHVPBCM" defer></script>
    <!-- / Fathom -->
</head>
<body class="antialiased text-gray-600 bg-gray-100">
<div class="max-w-6xl mx-auto py-3">
    <div class="w-full sm:w-3/4 p-4 sm:p-0 mx-auto mt-0 sm:mt-12">
        <div class="flex flex-col sm:flex-row gap-2 justify-between item-center">
            <img class="w-48" src="{{ mix('/images/findapr.svg') }}" alt="findapr.io logo">
            <a href="https://github.com/ash-jc-allen/find-a-pr"
               class="flex justify-center items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <img src="{{ mix('/images/github-logo.png') }}" class="w-6 pr-2 inline" alt="View on GitHub" />
                View on GitHub
            </a>
        </div>

        <div class="mt-12">
            <div class="flex justify-end md:justify-between items-center flex-wrap space-y-2 md:space-y-0">
                <x-sort-dropdown></x-sort-dropdown>

                <p class="text-right">
                    Found <span class="font-bold">{{ count($issues) }}</span> issue(s)
                </p>
            </div>

            @foreach($issues as $issue)
                <x-issue-card :issue="$issue" />
            @endforeach
        </div>

        <div class="text-center">
            <a href="https://ashallendesign.co.uk" class="bg-gray-200 hover:bg-gray-300 rounded shadow inline-block px-5 py-2 my-12 mx-auto">
                🚀 Powered by <span class="font-bold">Ash Allen Design</span>
            </a>
        </div>
    </div>
</div>
</body>
</html>
