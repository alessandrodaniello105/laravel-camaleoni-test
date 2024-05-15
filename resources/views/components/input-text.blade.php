@props([
    'name'
])

<input wire:model.fill="{{$name}}" type="text" name="{{$name}}" id="{{$name}}" {{$attributes}}>
