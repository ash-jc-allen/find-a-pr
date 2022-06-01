<div
    x-data="{
        currentSort: new URLSearchParams(location.search).get('sort'),
        sorters: [
            {'friendly': 'Random', 'field': 'random'},
            {'friendly': 'Created At', 'field': 'createdAt'},
            {'friendly': 'Title', 'field': 'title'},
            {'friendly': 'Repo Name', 'field': 'repoName'}
        ]
    }"
    x-init="$watch('currentSort', value => window.location.href = `/?sort=${value}`)"
>
    <label for="sort_order" class="inline-block">Sort by:</label>
    <select x-model="currentSort"
            id="sort_order"
            class="inline-block rounded-md border border-gray-300 shadow-sm px-2 py-2 ml-2 bg-white font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500"
    >
        <template x-for="sort in sorters">
            <option :value="sort.field" x-bind:selected="sort.field === currentSort" x-text="sort.friendly"></option>
        </template>
    </select>
</div>
