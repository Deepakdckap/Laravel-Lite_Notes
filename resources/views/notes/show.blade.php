<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- in this page we have to ways to write an trenary condition --}}
      {{-- 1.   {{ request()->routeIs('notes.show') ? __('Notes') : __('Trashed') }} --}}
      {{-- 2. --}} {{ !$note->trashed() ? __('Notes') : __('Trash') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- this to notify to user --}}
            {{-- @if(session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 text-center rounded-md">
                    {{ session('success') }}
                </div>
                @endif --}}
            {{--created  Component alert  --}}
                <x-alert-success>
                        {{ session('success') }}
                </x-alert-success>
            <div class="flex">
                @if (!$note->trashed())
                    <p class="opacity-70">
                        <strong>Created:</strong> {{ $note->created_at->diffForHumans() }}
                    </p>
                    <p class="opacity-70 ml-8">
                        <strong>Updated:</strong> {{ $note->updated_at->diffForHumans() }}
                    </p>
                    {{-- Create an edit Btn  by Rote binding model--}}
                    <a href="{{ route('notes.edit', $note) }}" class="btn-link ml-auto">Edit Note</a>

                    {{-- Delete Destroy method soft delete --}}
                    {{-- this action will go to the app/Http/Auth/NoteController.php and triges the destroy function--}}
                    <form action="{{ route('notes.destroy', $note) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger ml-4" onclick="return confirm('Are you wish to move to trash?')">move to trash</button>
                    </form>
                @else
                    <p class="opacity-70">
                        <strong>Deleted:</strong> {{ $note->deleted_at->diffForHumans() }}
                    </p>
                {{-- Create an edit Btn  by Rote binding model--}}
                    {{-- <a href="{{ route('notes.edit', $note) }}" class="btn-link ml-auto">Edit Note</a> --}}
{{-- changing the a link into button for restore the trashed.note --}}
                    {{-- this form action will send to routes/web.php  and trigers the trashed.update route--}}
                    <form action="{{ route('trashed.update', $note) }}" method="post" class="ml-auto">
                        @method('put')
                        @csrf
                        <button type="submit" class="btn-link ">restore note</button>
                    </form>

                    {{-- Delete Destroy method permenantly --}}
                    {{-- this action will go to the app/Http/Auth/NoteController.php and triges the destroy function--}}
                    <form action="{{ route('trashed.destroy', $note) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger ml-4" onclick="return confirm('Are you wish to delete this Note Permanently?')">delete forever</button>
                    </form>
                @endif
            </div>
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <h2 class="font-bold text-4xl">
                    {{ $note->title }}
                </h2>
                <p class="mt-6 whitespace-pre-wrap">{{ $note->text }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
