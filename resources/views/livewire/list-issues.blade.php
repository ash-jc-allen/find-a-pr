<div class="mt-12 flex">
    <x-side-bar :repos="$repos" :labels="$labels"/>

    <main class="w-full md:w-3/4">
        <div class="flex justify-end items-center flex-wrap space-y-2 md:space-y-0">
            <p class="text-right">
                Found <span class="font-bold">{{ count($issues) }}</span> issue(s)
            </p>
        </div>

        @foreach($issues as $issue)
            <x-issue-card :issue="$issue"/>
        @endforeach
    </main>
</div>
