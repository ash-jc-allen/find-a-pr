<div
    x-data="{
        currentSort: new URLSearchParams(location.search).get('sort'),
        sorters: [
            {'friendly': 'Random', 'field': 'random'},
            {'friendly': 'Created At (Newest First)', 'field': 'createdAt|desc'},
            {'friendly': 'Created At (Oldest First)', 'field': 'createdAt|asc'},
            {'friendly': 'Title (A-Z)', 'field': 'title|asc'},
            {'friendly': 'Title (Z-A)', 'field': 'title|desc'},
            {'friendly': 'Repo Name (A-Z)', 'field': 'repoName|asc'},
            {'friendly': 'Repo Name (Z-A)', 'field': 'repoName|desc'}
        ]
    }"
    x-init="$watch('currentSort', value => {
        window.location.href = `/?sort=${value}`
    })"
     class="w-full md:w-auto"
>
    <label for="sort_order" class="inline-block pb-1">Sort by:</label>
    <select x-model="currentSort"
            id="sort_order"
            class="w-full rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500"
    >
        <template x-for="sort in sorters">
            <option :value="sort.field"
                    x-bind:selected="sort.field === currentSort"
                    x-text="sort.friendly">
            </option>
        </template>
    </select>
</div>
