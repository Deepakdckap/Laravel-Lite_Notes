{{--  cannot be hard coded so that we are using the feild --}}
{{-- @props(['disabled' => false]) --}}

@props(['disabled' => false,'feild'=>''])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>

@error($feild)
<div class="text-red-600 text-sm">{{ $message }}</div>
@enderror
