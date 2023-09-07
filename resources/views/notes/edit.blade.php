<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <form action="{{ route('notes.update', $note) }}" method="post">
                    {{-- add method as it is by Laravel doc 9 Update --}}
                    @method('put')

                    {{-- this @csrf will genarate token for the input feild --}}
                    @csrf
                    <x-input type="text" name="title" feild="title" placeholder="Title" class="w-full" autocomplete="off" :value="@old('title', $note->title)" ></x-input>

                    <x-textarea name="text" feild="text" rows="10" placeholder="Start typing here..." class="w-full mt-6" :value="@old('text', $note->text)" ></x-textarea>

                    <button class="mt-6 but">Update Note</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
