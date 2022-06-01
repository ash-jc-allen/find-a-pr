<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head/>
<body class="antialiased text-gray-600 bg-gray-100">
<div class="max-w-6xl mx-auto py-3">
    <div class="w-full sm:w-3/4 p-4 sm:p-0 mx-auto mt-0 sm:mt-12">
        <x-header/>

        <div class="mt-12">
            <div class="flex justify-end md:justify-between items-center flex-wrap space-y-2 md:space-y-0">
                <x-sort-dropdown></x-sort-dropdown>

                <p class="text-right">
                    Found <span class="font-bold">{{ count($issues) }}</span> issue(s)
                </p>
            </div>

            @foreach($issues as $issue)
                <x-issue-card :issue="$issue" />
            @endforeach
        </div>

        <x-footer/>
    </div>
</div>
</body>
</html>
