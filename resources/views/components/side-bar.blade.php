@props([
    'repos',
    'labels',
    'sorts',
    'showIgnoredIssues',
    'ignoredUrls'
])

<div {{ $attributes->class('md:w-1/4 my-10 pr-6') }} x-transition>
    <label for="search" class="inline-block pb-1">Search:</label>
    <input id="search"
           x-ref="search"
           wire:model.debounce="searchTerm"
           type="search"
           placeholder="Search... (Press '/')"
           class="w-full rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500 dark:bg-slate-900 dark:border-slate-600 dark:focus:ring-offset-slate-700 dark:text-gray-100"
    >

    <hr class="my-6 border-gray-300 w-3/4 mx-auto dark:border-slate-500">

    <x-sort-dropdown :sorts="$sorts"></x-sort-dropdown>

    <hr class="my-6 border-gray-300 w-3/4 mx-auto dark:border-slate-500">

    @if($ignoredUrls)
        <div class="flex items-center justify-between" x-data="{ 'showIgnoredIssues': @entangle('showIgnoredIssues') }">
            <span class="flex-grow flex flex-col">
                <span class="text-sm font-medium" id="show-ignored-issues">Show {{ count($ignoredUrls) }} ignored {{ str('issue')->plural(count($ignoredUrls)) }}</span>
            </span>
            <button type="button" x-on:click="showIgnoredIssues = ! showIgnoredIssues" :class="showIgnoredIssues ? 'bg-green-500' : 'bg-gray-200'" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" role="switch" :aria-checked="showIgnoredIssues" aria-labelledby="show-ignored-issues">
                <span aria-hidden="true" :class="showIgnoredIssues ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
            </button>
        </div>

        <hr class="my-6 border-gray-300 w-3/4 mx-auto dark:border-slate-500">
    @endif

    <div class="hidden md:block">
        <div class="flex justify-between pb-1 items-center">
            <p>Repositories:</p>
            <p class="text-gray-400 text-sm">({{ $repos->count() }})</p>
        </div>

        <div x-data="{showMore: false}" class="overflow-hidden relative" :class="showMore ? '' : 'max-h-32'">
            @foreach($repos as $repo)
                <div>
                    <a href="https://github.com/{{ $repo->owner }}/{{ $repo->name }}" class="inline-block items-center px-3 py-1 my-0.5 rounded text-xs font-bold bg-green-400 dark:bg-green-600 text-white hover:bg-green-500 dark:hover:bg-green-700 transition ease-out">
                        {{ $repo->owner }}/{{ $repo->name }}
                    </a>
                </div>
            @endforeach

            <div x-on:click="showMore = ! showMore" :class="showMore ? '' : 'bg-gradient-to-t from-gray-100 dark:from-slate-700 to-transparent absolute left-0 bottom-0'" class="font-bold h-20 w-full z-10 text-center pt-14 hover:text-gray-500 cursor-pointer">
                <span x-text="showMore ? 'View less' : 'View more'" class="border-b border-b-green-400">View more</span>
            </div>
        </div>

        <hr class="my-6 border-gray-300 w-3/4 mx-auto dark:border-slate-500">

        <div class="flex justify-between pb-1 items-center">
            <p>Labels:</p>
            <p class="text-gray-400 text-sm">({{ count($labels) }})</p>
        </div>

        @foreach($labels as $label)
            <div>
                <p class="inline-block items-center px-3 py-1 my-0.5 rounded text-xs font-bold border bg-gray-400 dark:bg-gray-600 text-white">
                    {{ $label }}
                </p>
            </div>
        @endforeach
    </div>
</div>
