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

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="antialiased text-gray-600 bg-gray-100">
<div class="max-w-6xl mx-auto py-3">
    <div class="w-3/4 mx-auto mt-12">
        <div class="flex justify-between item-center">
            <img class="w-48" src="/images/findapr.svg" alt="findapr.io logo">
            <a href="https://github.com/ash-jc-allen/find-a-pr"
               class="flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <img src="/images/github-logo.png" class="w-6 pr-2 inline">
                View on GitHub
            </a>
        </div>

        <div class="mt-12">
            <p class="text-right">
                Found <span class="font-bold">{{ count($issues) }}</span> issue(s)
            </p>

            @foreach($issues as $issue)
                <div class="border py-5 px-8 my-4 rounded-lg shadow bg-white">
                    <div class="flex justify-between item-center">
                        <div class="w-3/4">
                            <a href="{{ $issue->url }}" class="text-xl font-bold inline-block">{{ $issue->title }}</a>
                            <div>
                                <a href="{{ $issue->repoUrl }}" class="text-gray-400">{{ $issue->repoName }}</a>
                            </div>
                        </div>
                        <div>
                            <a href="{{ $issue->url }}"
                               class="block items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-400 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">View
                                Issue</a>
                        </div>
                    </div>

                    <div class="my-2">
                        @foreach($issue->labels as $label)
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border bg-opacity-20"
                                style="color: {{ $label->color }}; border-color: {{ $label->color }}; background-color: {{ $label->color.'30' }}">
                        {{ $label->name }}
                    </span>
                        @endforeach
                    </div>

                    <p class="my-4">
                        {{ str($issue->body)->limit(150) }}
                    </p>

                    <div class="flex justify-between items-center">
                        <a href="{{ $issue->createdBy->url }}"
                           class="border hover:bg-gray-100 inline-block p-2 rounded">
                            <img src="{{ $issue->createdBy->profilePictureUrl }}"
                                 class="inline-block h-6 w-6 rounded-full">
                            <p class="inline">{{ $issue->createdBy->name }}</p>
                        </a>

                        <p class="text-sm text-gray-400">{{ $issue->createdAt->format('jS M Y @ H:i') }}</p>
                    </div>

                </div>
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
