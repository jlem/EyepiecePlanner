@extends('layouts.app')
@section('content')
    <telescope-form :changes="changeHandler" :telescopes="telescopes" :selected-telescope="selectedTelescope" :pupil-size="pupil_size"></telescope-form>
    <eyepiece-list :eyepieces="filteredEyepieces" :telescope="selectedTelescope"></eyepiece-list>
    <eyepiece-filter></eyepiece-filter>
@endsection
@section('page-script')
    <script src="/js/eyepiece-recommendations.js"></script>
@endsection
