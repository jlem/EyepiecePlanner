@extends('layouts.app')

@section('content')
    <div class="panel">
        <eyepiece-list :eyepieces="eyepieces" :telescopes="telescopes" :list-config="listConfig"></eyepiece-list>
    </div>
@endsection
@section('page-script')
    <script src="/js/eyepiece-index.js"></script>
@endsection
