<div class="border dark:border-slate-600 p-4 sm:py-5 sm:px-8 my-4 rounded-lg shadow bg-white dark:bg-slate-800">
    <div class="flex flex-col sm:flex-row justify-start sm:justify-between items-start gap-2">
        <div class="w-full md:w-3/4">
            <a href="{{ $issue->url }}" class="text-xl font-bold inline-block">{{ $issue->title }}</a>
            <div>
                <a href="{{ $issue->repoUrl }}" class="text-gray-400">{{ $issue->repoName }}</a>
            </div>
        </div>
        <div>
            <a href="{{ $issue->url }}"
               class="w-full inline-block px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-400 dark:bg-green-600 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:hover:bg-green-700 transition ease-out">View
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

    <div class="flex flex-col sm:flex-row gap-2 justify-between items-start sm:items-center">
        <a href="{{ $issue->createdBy->url }}"
           class="border hover:bg-gray-100 inline-block p-2 rounded dark:border-slate-600 dark:hover:bg-slate-600 transition ease-out">
            <img src="{{ $issue->createdBy->profilePictureUrl }}"
                 class="inline-block h-6 w-6 rounded-full" alt="{{ $issue->createdBy->name }}">
            <p class="inline">{{ $issue->createdBy->name }}</p>
        </a>

        <p class="text-sm text-gray-400">{{ $issue->createdAt->format('jS M Y @ H:i') }}</p>
    </div>

</div>
