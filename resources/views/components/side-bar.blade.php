@props([
    'repos',
    'labels',
    'sorts',
])

<div class="hidden w-1/4 pr-6 my-10 md:block">
    <label for="search" class="inline-block pb-1">Search:</label>
    <input id="search"
           wire:model.debounce="searchTerm"
           type="search"
           placeholder="Search..."
           class="w-full px-2 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500 dark:bg-slate-900 dark:border-slate-600 dark:focus:ring-offset-slate-700 dark:text-gray-100"
    >

    <hr class="w-3/4 mx-auto my-6 border-gray-300 dark:border-slate-500">

    <x-sort-dropdown :sorts="$sorts"></x-sort-dropdown>

    <hr class="w-3/4 mx-auto my-6 border-gray-300 dark:border-slate-500">

    <div class="flex items-center justify-between pb-1">
        <p>Repositories:</p>
        <p class="text-sm text-gray-400">({{ $repos->count() }})</p>
    </div>

    @foreach($repos as $repo)
        <div>
            <a href="https://github.com/{{ $repo['owner'] }}/{{ $repo['name'] }}" class="inline-block items-center px-3 py-1 my-0.5 rounded text-xs font-bold bg-green-400 dark:bg-green-600 text-white hover:bg-green-500 dark:hover:bg-green-700 transition ease-out">
                {{ $repo['owner'] }}/{{ $repo['name'] }}
            </a>
        </div>
    @endforeach

    <hr class="w-3/4 mx-auto my-6 border-gray-300 dark:border-slate-500">

    <div class="flex items-center justify-between pb-1">
        <p>Labels:</p>
        <p class="text-sm text-gray-400">({{ count($labels) }})</p>
    </div>

    @foreach($labels as $label)
        <div>
            <p class="inline-block items-center px-3 py-1 my-0.5 rounded text-xs font-bold border bg-gray-400 dark:bg-gray-600 text-white">
                {{ $label }}
            </p>
        </div>
    @endforeach
</div>
