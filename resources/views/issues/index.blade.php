@extends('layout')

@section('content')
    <main class="mt-12">
        <p class="text-right">
            Found <span class="font-bold">{{ count($issues) }}</span> issue(s)
        </p>

        @foreach($issues as $issue)
            <x-issue-list-item :issue="$issue" />
        @endforeach
    </main>
@endsection
