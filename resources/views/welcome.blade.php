@extends('layouts/default')

@section('content')

@php
$theory = new \App\Theory\Theory(Request::get('root', 'C'));
@endphp

<div class="min-h-screen">
    <main class="w-main px-20 py-8">
        <form action="./" method="GET">

            <div class="mb-5">
                <label id="listbox-label" class="block text-sm font-medium text-gray-700"> Root Note </label>
                <div class="mt-1 relative">

                    <select id="root" name="root"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach ($theory->scale() as $note)
                        <option {{ Request::get('root') == $note ? 'selected' : null }} value="{{ $note }}">{{ $note }}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="mb-5">
                <label id="listbox-label" class="block text-sm font-medium text-gray-700"> Scale </label>
                <div class="mt-1 relative">

                    <select id="scale" name="scale"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach ($theory->scales as $id => $info)
                        <option {{ Request::get('scale') == $id ? 'selected' : null }} value="{{ $id }}">{{ $id }}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="mb-14">
                <label id="listbox-label" class="block text-sm font-medium text-gray-700"> Chord </label>
                <div class="mt-1 relative">

                    <select id="chord" name="chord"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">-- Chord --</option>
                        @foreach ($theory->chords as $id => $info)
                        <option {{ Request::get('chord') == $id ? 'selected' : null }} value="{{ $id }}">{{ $info['name'] }}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <x-fretboard
                root="{{ $theory->root }}"
                scale="{{ Request::get('scale') }}"
                chord="{{ Request::get('chord') }}"></x-fretboard>

            <x-button tag="button"
                class="w-full mt-16 items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Apply</x-button>

        </form>
    </main>
</div>
@endsection
