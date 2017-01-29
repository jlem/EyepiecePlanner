@extends('layouts.app')

@section('content')
    <div class="container">
        <eyepiece-list v-bind:eyepieces="eyepieces" v-bind:telescope="telescope"></eyepiece-list>
    </div>
@endsection
@section('page-data')
    <script>
        window.eyepieces = JSON.parse('{!! $eyepieces !!}');
        window.telescope = null;
    </script>
@endsection
@section('page-script')
    <script>
        new Vue({
            el: '#app',
            data: {
                eyepieces: window.eyepieces,
                telescope: window.telescope
            }
        });
    </script>
@endsection