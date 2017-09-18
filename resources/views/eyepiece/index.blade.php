@extends('layouts.app')

@section('content')
    <div class="content-panel">
        <router-view></router-view>
    </div>
@endsection
@section('page-script')
    <script src="/js/main.js"></script>
@endsection
