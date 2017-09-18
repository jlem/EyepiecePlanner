@extends('layouts.app')

@section('content')
    <div class="content-panel">
        <router-link to="/">Home</router-link>
        <router-link to="/telescopes">My Telescopes</router-link>
        <router-view></router-view>
    </div>
@endsection
@section('page-script')
    <script src="/js/main.js"></script>
@endsection
