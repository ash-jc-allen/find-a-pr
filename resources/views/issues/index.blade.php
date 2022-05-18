<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>findapr.io - Find Your First Laravel PR</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="max-w-6xl mx-auto py-3">
    <img class="w-64" src="/images/findapr.svg" alt="findapr.io logo">

    @foreach($issues as $issue)
        <div class="border py-5 px-8 my-3 w-3/4 mx-auto rounded shadow">
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl font-bold">{{ $issue->title }}</h2>
                    <a href="{{ $issue->repoUrl }}">{{ $issue->repoName }}</a>
                </div>
                <a href="{{ $issue->url }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">View Issue</a>
            </div>

            <div>
                @foreach($issue->labels as $label)
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border bg-opacity-20" style="color: {{ $label->color }}; border-color: {{ $label->color }}; background-color: {{ $label->color.'30' }}">
                        {{ $label->name }}
                    </span>
                @endforeach
            </div>

            <p>
                {{ str($issue->body)->limit(150) }}
            </p>

            <div class="flex justify-between">
                <a href="{{ $issue->createdBy->url }}" class="border hover:bg-gray-100 inline-block p-2 rounded">
                    <img src="{{ $issue->createdBy->profilePictureUrl }}" class="inline-block h-6 w-6 rounded-full">
                    <p class="inline">{{ $issue->createdBy->name }}</p>
                </a>

                <p>{{ $issue->createdAt->format('jS M Y @ H:i') }}</p>
            </div>

        </div>
    @endforeach
</div>
</body>
</html>
