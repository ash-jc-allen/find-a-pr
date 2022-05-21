<article class="relative py-5 px-4 sm-px-8 my-4 sm:rounded-lg shadow dark:shadow-gray-700 bg-white dark:bg-transparent">
    <header class="flex justify-between item-center">
        <div class="w-3/4">
            <h1><a href="{{ $issue->url }}" class="text-xl leading-none font-bold inline-block">{{ $issue->title }}</a></h1>
            <div>
                <a href="{{ $issue->repoUrl }}" class="text-gray-400">{{ $issue->repoName }}</a>
            </div>
        </div>

        <a href="{{ $issue->url }}"
           class="absolute top-0 right-0 items-center px-3 py-1 sm:px-5 sm:py-2 text-sm font-medium rounded-bl-md sm:rounded-tr-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">View
            Issue</a>

    </header>

    <div class="my-2">
        @foreach($issue->labels as $label)
            <span
                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border bg-opacity-20"
                style="color: {{ $label->color }}; border-color: {{ $label->color }}; background-color: {{ $label->color.'30' }}">
                        {{ $label->name }}
                    </span>
        @endforeach
    </div>

    <p class="text-sm sm:text-base my-4 text-ellipsis overflow-hidden">
        {{ str($issue->body)->limit(150) }}
    </p>

    <div class="flex justify-between items-center">
        <a href="{{ $issue->createdBy->url }}"
           class="hover:bg-gray-100 inline-block">
            <img src="{{ $issue->createdBy->profilePictureUrl }}"
                 class="inline-block h-6 w-6 rounded-full">
            <p class="inline">{{ $issue->createdBy->name }}</p>
        </a>

        <p class="text-sm text-gray-400">{{ $issue->createdAt->format('jS M Y @ H:i') }}</p>
    </div>

</article>
