<div
    x-data="{
        'ignoredUrls': @entangle('ignoredUrls'),
        getIgnoredUrls(){
            this.ignoredUrls = Array.from(JSON.parse(localStorage.getItem('ignoreUrl')) || []);
        }
    }"
    x-init="getIgnoredUrls();"
    class="mt-12 flex">
    <x-side-bar :repos="$repos" :labels="$labels" :sorts="$sorts" :ignored-urls="$ignoredUrls"/>

    <main class="w-full md:w-3/4">
        <div class="flex justify-end items-center flex-wrap space-y-2 md:space-y-0">
            <p class="text-right">
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
                <p>It looks there aren't any issues that fit your criteria.</p>
            </div>
        @endforelse
    </main>
</div>
