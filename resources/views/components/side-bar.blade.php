@props([
    'repos',
    'labels',
])

<div class="w-1/4 my-10 pr-6 hidden md:block">
    <x-sort-dropdown></x-sort-dropdown>

    <hr class="my-6 border-gray-300 w-3/4 mx-auto">

    <p class="block pb-1">Repositories:</p>

    @foreach($repos as $repo)
        <div>
            <a href="https://github.com/{{ $repo['owner'] }}/{{ $repo['name'] }}" class="inline-block items-center px-3 py-1 my-0.5 rounded text-xs font-bold border bg-green-400 text-white hover:bg-green-600">
                {{ $repo['owner'] }}/{{ $repo['name'] }}
            </a>
        </div>
    @endforeach

    <hr class="my-6 border-gray-300 w-3/4 mx-auto">

    <p class="inline-block pb-1">Labels:</p>

    @foreach($labels as $label)
        <div>
            <p class="inline-block items-center px-3 py-1 my-0.5 rounded text-xs font-bold border bg-gray-400 text-white">
                {{ $label }}
            </p>
        </div>
    @endforeach
</div>
