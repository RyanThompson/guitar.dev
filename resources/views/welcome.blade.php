@extends('layouts/default')

@section('content')
<div class="flex flex-wrap min-h-screen">
    <main class="w-main px-20 py-8">
        
        <x-fretboard></x-fretboard>
        
        <x-tab></x-tab>

    </main>
</div>
@endsection
