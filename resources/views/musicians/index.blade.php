@extends('layouts.app')

@section('content')
{{-- <div>

    @include('components.custom-select.index')
</div> --}}

<div class="title text-center my-3">
    <h1>Lista musicisti</h1>

</div>

{{-- ALL MUSICIANS LIST --}}
<table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nome</th>
        <th scope="col">Cognome</th>
        <th scope="col">Strumento</th>
        <th scope="col">has_played</th>
        <th scope="col">is_picked</th>
        <th scope="col">Azioni</th>
      </tr>
    </thead>

    <tbody>
        @foreach ($musicians as $musician)
            <tr>
                <th scope="row">{{$musician->id}}</th>
                <td>{{$musician->name}}</td>
                <td>{{$musician->surname}}</td>
                <td>{{$musician->instrument->name}}</td>
                <td>{{$musician->has_played}}</td>
                <td>{{$musician->is_picked}}</td>
                <td>
                    <a class="btn btn-warning " href="{{route('musicians.edit', $musician->id)}}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
            </tr>
        @endforeach



    </tbody>

</table>



@endsection

