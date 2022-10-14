@props(['issue', 'isIgnored'])

<div class="p-4 my-4 break-words bg-white border rounded-lg shadow dark:border-slate-600 sm:py-5 sm:px-8 dark:bg-slate-800" wire:loading.class="animate-pulse" x-data="{showMore: false}">
    <div class="flex flex-col items-start justify-start gap-2 sm:flex-row sm:justify-between">
        <div class="w-full md:w-3/4">
            <a href="{{ $issue->url }}" target="_blank"
                class="inline-block w-full text-xl font-bold">{{ $issue->title }}
            </a>
            <div>
                <a href="{{ $issue->repoUrl }}" target="_blank" class="text-gray-400">{{ $issue->repoName }}</a>
            </div>
        </div>

        <div class="flex">
            <a href="{{ $issue->url }}" target="_blank"
                class="inline-block w-full px-5 py-2 text-sm font-medium text-white transition ease-out bg-green-400 border border-transparent rounded-md shadow-sm dark:bg-green-600 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:hover:bg-green-700">View
                Issue
            </a>
            <x-ignore-issue issueUrl="{{ $issue->url }}" :is-ignored="$isIgnored" />
        </div>
    </div>

    <div class="my-2 space-x-0.5">
        @foreach ($issue->labels as $label)
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border bg-opacity-20"
                style="color: {{ $label->color }}; border-color: {{ $label->color }}; background-color: {{ $label->color . '30' }}">
                {{ $label->name }}
            </span>
        @endforeach
    </div>


    <div class="my-4 overflow-hidden relative" :class="showMore ? '' : 'max-h-32'">
        <article class="prose dark:prose-invert">
            {!! str($issue->body)->markdown(['html_input' => 'strip']) !!}
        </article>
        <div x-on:click="showMore = ! showMore" :class="showMore ? '' : 'bg-gradient-to-t from-white dark:from-slate-800 to-transparent absolute left-0 bottom-0'" class="font-bold h-20 w-full z-10 text-center pt-14 hover:text-gray-500 cursor-pointer">
            <span x-text="showMore ? 'View less' : 'View more'" class="border-b border-b-green-400">View more</span>
        </div>
    </div>

    <div class="my-3">
        @if($issue->commentCount > 0)
            <span class="inline-flex items-center px-2 py-1 text-sm border rounded bg-opacity-20 dark:border-slate-600">
                {{ $issue->commentCount }} {{ str('comment')->plural($issue->commentCount) }}
            </span>
        @endif

        @foreach ($issue->reactions as $reaction)
            @if ($reaction->count > 0)
                <span class="inline-flex items-center px-2 py-1 text-sm border rounded bg-opacity-20 dark:border-slate-600">
                    {{ $reaction->emoji }} {{ $reaction->count }}
                </span>
            @endif
        @endforeach
    </div>

    <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:items-center">
        <a href="{{ $issue->createdBy->url }}" target="_blank"
            class="inline-block p-2 transition ease-out border rounded hover:bg-gray-100 dark:border-slate-600 dark:hover:bg-slate-600">
            <img src="{{ $issue->createdBy->profilePictureUrl }}" class="inline-block w-6 h-6 rounded-full"
                alt="{{ $issue->createdBy->name }}">
            <p class="inline">{{ $issue->createdBy->name }}</p>
        </a>

        <p class="text-sm text-gray-400">{{ $issue->createdAt->format('jS M Y @ H:i') }}</p>
    </div>

</div>
