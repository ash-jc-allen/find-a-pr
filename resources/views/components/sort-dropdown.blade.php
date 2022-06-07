<div class="w-full md:w-auto">
    <label for="sort_order" class="inline-block pb-1">Sort by:</label>
    <select wire:model="sort"
            id="sort_order"
            class="w-full px-2 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500 dark:bg-slate-900 dark:border-slate-600 dark:focus:ring-offset-slate-700 dark:text-gray-100"
    >
        @foreach($sorts as $sortKey => $sort)
            <option value="{{ $sortKey }}">
                {{ $sort['friendly'] }}
            </option>
        @endforeach
    </select>
</div>
