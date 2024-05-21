@props([
    'name'
])

<input wire:model.fill.live="{{$name}}" type="text" name="{{$name}}" id="{{$name}}" {{$attributes}}>
