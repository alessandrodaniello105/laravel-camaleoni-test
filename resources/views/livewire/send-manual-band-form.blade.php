@props([
    'formName'
])
<button
type="submit"
form="{{$formName}}"
class="btn btn-dark send-btn {{ ($isDisabled)? 'disabled' : '' }}"
id="{{$formName}}-send-btn">
Create band
</button>
