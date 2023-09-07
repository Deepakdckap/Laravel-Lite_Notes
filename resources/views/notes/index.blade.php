{{-- this file will display all notes in the UI --}}
<?php
use App\Models\Note;
use App\Http\Controllers\TrashedNoteController;
?>

<x-app-layout>
    <x-slot name="header">
        {{-- Initial code --}}
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2> --}}
        {{-- -------- --}}
        {{-- below code is for if condition for the trash ui --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->routeIs('notes.index') ? __('Notes') : __('Trash') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- this success msg is for deleted note --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-red-100 border border-red-200 text-red-700 text-center rounded-md">
                    {{ session('success') }}
                </div>
            @endif
        {{-- This delete notfication alert created by componets --}}
            {{-- <x-alert-success>
                {{ session('success') }}
            </x-alert-success> --}}

            {{-- ---------------- --}}
            @if (request()->routeIs('notes.index'))
                <a href="{{ route('notes.create') }}" class="btn-link btn-lg mb-2">+New Note</a>
            @endif

            @forelse($notes as $note)
                <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                    <h2 class="font-bold text-2xl">
                        {{-- {{ $note->title }} --}}
                        {{-- create an hyperlink to show an single note --}}
                        {{-- <a href="{{ route('notes.show', $note->uuid) }}">{{ $note->title }} </a> --}}
                        {{-- --------- --}}
                        {{-- Route Model Binding && works for the both notes.show and trashed.show as to fetch a particular note --}}
                        <a
                        @if (request()->routeIs('notes.index'))
                        {{-- @if(!$note->trashed()) --}}
                            href="{{ route('notes.show', $note) }}"
                        @else
                            {{-- href="{{ route('notes.show', $note) }}" --}}
                            href="{{ route('trashed.show', $note) }}"
                        @endif
                        >{{ $note->title }}  </a>
                        {{-- --------- --}}

                    </h2>
                    <p class="mt-2">
                        {{-- This Str::limit() is used for reduce the charcters in UI --}}
                        {{ Str::limit($note->text, 200) }}
                    </p>
                    {{-- this diffForHumans() key word is used for time readable --}}
                    <span class="block mt-4 text-sm opacity-70">{{ $note->updated_at->diffForHumans() }}</span>
                </div>
                @empty

                    @if (request()->routeIs('notes.index'))
                    <p>You have No Notes, yet.</p>
                    @else
                    <p>No Items in the Trash!</p>
                    @endif
                @endforelse

                    {{-- This below code is used to create a pagination in the window --}}
                    {{ $notes->links() }}
                </div>
        </div>
</x-app-layout>
