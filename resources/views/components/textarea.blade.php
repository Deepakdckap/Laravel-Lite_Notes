@props(['disabled' => false, 'feild'=>'', 'value'=>''])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>{{ $value }}</textarea>

{{-- Cannot be hard coded like this so that we are using $feild  --}}
{{-- @error('text')
    <div class="text-red-600 text-sm">{{ $message }}</div>
@enderror --}}

{{-- -------- $feild --}}
@error($feild)
    <div class="text-red-600 text-sm">{{ $message }}</div>
@enderror
