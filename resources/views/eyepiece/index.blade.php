@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Heading -->
        <div>
            @if (isAdmin())
                <a class="pull-right btn btn-primary" href="/eyepiece/create">Add Eyepiece</a>
            @endif
            <h1>Eyepieces</h1>
        </div>

        <!-- Eyepiece List -->
        <div class="row">
            <div class="col-md-12">
                <eyepiece-list :eyepieces="eyepieces"></eyepiece-list>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        new Vue({
            el: '#app',
            data: {
                eyepieces: JSON.parse('{!! $eyepieces !!}')
            }
        });
    </script>
@endsection
