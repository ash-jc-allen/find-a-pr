<div
    x-data="{
        'showSideBar': false,
        'ignoredUrls': @entangle('ignoredUrls').live,
        getIgnoredUrls(){
            $wire.updateIgnoredUrls(Array.from(JSON.parse(localStorage.getItem('ignoreUrl')) || []));
        }
    }"
    x-init="getIgnoredUrls();"
    class="mt-12 md:flex"
    @keydown.slash.window.prevent="$refs.search.focus()">

    <x-side-bar :repos="$repos" :labels="$labels" :sorts="$sorts" :ignored-urls="$ignoredUrls" x-show="showSideBar" class="block md:hidden" x-cloak/>
    <x-side-bar :repos="$repos" :labels="$labels" :sorts="$sorts" :ignored-urls="$ignoredUrls" class="hidden md:block"/>

    <main class="w-full md:w-3/4">
        <div class="flex justify-between md:justify-end items-center flex-wrap">
            <button type="button"
                    x-on:click="showSideBar = ! showSideBar"
                    x-text="showSideBar ? 'Hide filter' : 'Show filter'"
                    class="flex md:hidden justify-center items-center px-4 py-1.5 border border-transparent font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-gray-900 transition ease-out"
            >
            </button>
            <p>
                Found <span class="font-bold">{{ count($issues) }}</span> {{ $showIgnoredIssues ? 'ignored' : '' }} {{ str('issue')->plural(count($issues)) }}
            </p>
        </div>

        @if($shouldDisplayFirstTimeNotice)
            <x-first-time-notice/>
        @endif

        @forelse($issues as $issue)
            <x-issue-card :issue="$issue" :is-ignored="in_array($issue->url, $ignoredUrls)"/>
        @empty
            <div class="my-14 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>

                <p class="font-medium my-4">No {{ $showIgnoredIssues ? 'Ignored' : '' }} Issues Found!</p>
                <p>It looks like there aren't any issues that fit your criteria.</p>
            </div>
        @endforelse
    </main>
</div>
