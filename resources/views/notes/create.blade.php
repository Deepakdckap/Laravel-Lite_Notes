{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
            <form action="" method="post">
                <x-input type="text" name="title" placeholder="Title" class="w-full" autocomplete="off"></x-input>
                <x-textarea name="text" rows="10" placeholder="Start typing here..." class="w-full mt-6"></x-textarea>
            </form>
            </div>
        </div>
    </div>
</x-app-layout> --}}

{{-- git code  --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">

                {{-- this loop is to show the error msg for user above the input feild--}}
                {{-- @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach --}}

                <form action="{{ route('notes.store') }}" method="post">
                    {{-- this @csrf will genarate token for the input feild --}}
                    @csrf
                    <x-input type="text" name="title" feild="title" placeholder="Title" class="w-full" autocomplete="off" :value="@old('title')" ></x-input>
                    {{-- Name of the input feild as parameter --}}
                    {{-- @error('title')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror --}}

                    <x-textarea name="text" feild="text" rows="10" placeholder="Start typing here..." class="w-full mt-6" :value="@old('text')" ></x-textarea>

                    <button class="mt-6 but">Save Note</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
