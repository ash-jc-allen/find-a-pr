<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head/>
<body class="antialiased text-gray-600 bg-gray-100">
<div class="max-w-6xl mx-auto py-3">
    <div class="w-full p-4 sm:p-0 mx-auto mt-0 sm:mt-12">
        <x-header/>

        <div class="mt-12 flex">
            <x-side-bar :repos="$repos" :labels="$labels"/>

            <main class="w-full md:w-3/4">
                <div class="flex justify-end items-center flex-wrap space-y-2 md:space-y-0">
                    <p class="text-right">
                        Found <span class="font-bold">{{ count($issues) }}</span> issue(s)
                    </p>
                </div>

                @foreach($issues as $issue)
                    <x-issue-card :issue="$issue" />
                @endforeach
            </main>
        </div>

        <x-footer/>
    </div>
</div>
</body>
</html>
