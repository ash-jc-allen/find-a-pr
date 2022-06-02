@props([
    'repos',
    'labels',
    'sorts',
])

<div class="w-1/4 my-10 pr-6 hidden md:block">
    <label for="search" class="inline-block pb-1">Search:</label>
    <input id="search"
           wire:model.debounce="searchTerm"
           type="search"
           placeholder="Search..."
           class="w-full rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500 dark:bg-slate-900 dark:border-slate-600 dark:focus:ring-offset-slate-700 dark:text-gray-100"
    >

    <hr class="my-6 border-gray-300 w-3/4 mx-auto dark:border-slate-500">

    <x-sort-dropdown :sorts="$sorts"></x-sort-dropdown>

    <hr class="my-6 border-gray-300 w-3/4 mx-auto dark:border-slate-500">

    <div class="flex justify-between pb-1 items-center">
        <p>Repositories:</p>
        <p class="text-gray-400 text-sm">({{ $repos->count() }})</p>
    </div>

    @foreach($repos as $repo)
        <div>
            <a href="https://github.com/{{ $repo['owner'] }}/{{ $repo['name'] }}" class="inline-block items-center px-3 py-1 my-0.5 rounded text-xs font-bold bg-green-400 dark:bg-green-600 text-white hover:bg-green-600">
                {{ $repo['owner'] }}/{{ $repo['name'] }}
            </a>
        </div>
    @endforeach

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
