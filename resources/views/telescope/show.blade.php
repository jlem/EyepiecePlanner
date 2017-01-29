@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Telescope Selection -->

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    @foreach($telescopes as $telescope)
                        @if($selectedTelescope->getID() === $telescope->getID())
                            <li class="active"><a href="">{{ $telescope->getName() }}</a></li>
                        @else
                            <li><a href="/telescope/{{ $telescope->getID() }}">{{ $telescope->getName() }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>


        <!-- Heading -->

        <div>
            <a class="pull-right btn btn-primary" href="/telescope/{{ $selectedTelescope->getID() }}/edit">Edit Telescope</a>
            <h1>{{ $selectedTelescope->getName() }}</h1>
        </div>


        <!-- Telescope Details -->

        <div class="row">
            <div class="col-md-12">
                <h3>Details</h3>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Aperture</dt>
                            <dd>{{ $selectedTelescope->getAperture() }} mm ({{ $selectedTelescope->getApertureInches() }}")</dd>
                            <dt>Focal Length</dt>
                            <dd>{{ $selectedTelescope->getFocalLength() }} mm</dd>
                            <dt>Max Mag. Per Inch</dt>
                            <dd>{{ $selectedTelescope->getMaxMagnification() }}x / inch</dd>
                            <dt>Max Magnification</dt>
                            <dd>{{ $selectedTelescope->calculateMaxMagnification() }}x</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>


        <!-- Eyepiece Telescope Calculations -->

        <div class="row">
            <div class="col-md-12">
                <h3>Eyepiece Calculations</h3>
                <eyepiece-list :eyepieces="eyepieces" :telescope="telescope"></eyepiece-list>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        new Vue({
            el: '#app',
            data: {
                eyepieces: JSON.parse('{!! $eyepieces !!}'),
                telescope: {
                    aperture: '{{ $selectedTelescope->getAperture() }}',
                    focal_length: '{{ $selectedTelescope->getFocalLength() }}',
                    max_magnification: '{{ $selectedTelescope->getMaxMagnification() }}'
                }
            }
        });
    </script>
@endsection
