@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Heading -->
        <h1>
            @if(isAdmin())
                <a class="pull-right btn btn-primary" href="/eyepiece/{{ $eyepiece->getID() }}/edit">Edit Eyepiece</a>
            @endif
            {{ $eyepiece->getDescription() }}
        </h1>
@endsection
