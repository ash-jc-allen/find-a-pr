<div class="w-full md:w-auto">
    <label for="sort_order" class="inline-block pb-1">Sort by:</label>
    <select wire:model="sort"
            id="sort_order"
            class="w-full rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500"
    >
        @foreach($sorts as $sortKey => $sort)
            <option value="{{ $sortKey }}">
                {{ $sort['friendly'] }}
            </option>
        @endforeach
    </select>
</div>
