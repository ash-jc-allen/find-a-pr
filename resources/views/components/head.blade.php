<head>
    <title>findapr.io - Find Your First Laravel PR</title>
    @laravelPWA

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
    <link href="https://fonts.bunny.net/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @production
        <!-- Fathom - beautiful, simple website analytics -->
        <script src="https://cdn.usefathom.com/script.js" data-site="CAHVPBCM" defer></script>
        <!-- / Fathom -->
    @endproduction

    @livewireStyles
</head>
