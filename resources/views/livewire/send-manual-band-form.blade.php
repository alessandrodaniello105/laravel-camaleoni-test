@props([
    'formName'
])
<button
type="submit"
form="{{$formName}}"
class="btn btn-dark {{ ($isDisabled)? 'disabled' : '' }}">
Create band
</button>
