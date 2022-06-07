<div
    x-data="{
        'ignoredUrls': @entangle('ignoredUrls'),
        getIgnoredUrls(){
            this.ignoredUrls = Array.from(JSON.parse(localStorage.getItem('ignoreUrl')) || []);
        }
    }"
    x-init="getIgnoredUrls();"
    class="flex mt-12">
    <x-side-bar :repos="$repos" :labels="$labels" :sorts="$sorts"/>

    <main class="w-full md:w-3/4">
        <div class="flex flex-wrap items-center justify-end space-y-2 md:space-y-0">
            <p class="text-right">
                Found <span class="font-bold">{{ count($issues) }}</span> issue(s)
            </p>
        </div>

        @if($shouldDisplayFirstTimeNotice)
            <x-first-time-notice/>
        @endif

        @forelse($issues as $issue)
            <x-issue-card :issue="$issue"/>
        @empty
            <div class="text-center my-14">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>

                <p class="my-4 font-medium">No Issues Found!</p>
                <p>It looks there aren't any issues that fit your criteria.</p>
            </div>
        @endforelse
    </main>
</div>
