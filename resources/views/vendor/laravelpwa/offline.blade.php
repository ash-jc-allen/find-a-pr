@extends('layouts.app')

@section('content')
    <div class="antialiased text-gray-600 dark:text-gray-100 bg-gray-100 dark:bg-slate-700">
        <div class="max-w-6xl mx-auto w-full h-screen p-4 flex flex-col text-center items-center justify-center">
            <img class="w-48 dark:hidden" src="{{ asset('images/findapr.svg') }}" alt="findapr.io logo - light mode">
            <img class="w-48 hidden dark:block" src="{{ asset('images/findapr-white.svg') }}" alt="findapr.io logo - dark mode">

            <p class="pt-4">You are currently offline!</p>
        </div>
    </div>
@endsection
