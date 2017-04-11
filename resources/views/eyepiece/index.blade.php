@extends('layouts.app')

@section('content')
    <div class="panel">
        <eyepiece-list :eyepieces="eyepieces" :telescopes="telescopes"></eyepiece-list>
    </div>
@endsection
@section('page-script')
    <script>
        new Vue({
            el: "#app",
            data: {
                eyepieces: window.eyepieces,
                telescopes: window.telescopes
            }
        });
    </script>
@endsection
