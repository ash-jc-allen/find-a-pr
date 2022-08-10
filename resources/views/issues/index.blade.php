@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-3" x-cloak>
    <div class="w-full p-4 xs:p-0 mx-auto mt-0 sm:mt-12">
        <x-header/>

        @livewire('list-issues')

        <x-notifications/>

        <x-footer/>
    </div>
</div>
@endsection
