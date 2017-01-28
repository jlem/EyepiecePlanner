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


        <!-- Eyepiece Details -->

        <div class="row">
            <div class="col-md-12">
                <h3>Details</h3>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Focal Length</dt>
                            <dd>{{ $eyepiece->getFocalLength() }} mm</dd>
                            <dt>Apparent Field</dt>
                            <dd>{{ $eyepiece->getApparentField() }}°</dd>
                            <dt>Eye Relief</dt>
                            <dd>{{ $eyepiece->getEyeRelief() }} mm</dd>
                            <dt>Barrel Size</dt>
                            <dd>{{ $eyepiece->getBarrelSize() }} in.</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>


        <!-- Eyepiece Telescope Calculations -->

        @if (Auth::check())
            <div class="row">
                <div class="col-md-12">
                    <h3>Telescope Calculations</h3>
                    <div class="panel panel-default">
                        <table class="table table-bordered">
                            <tr>
                                <th>Telescope</th>
                                <th>Magnification</th>
                                <th>True FoV</th>
                                <th>Exit Pupil</th>
                            </tr>
                            @foreach($telescopes as $telescope)
                                <tr>
                                    <td>{{ $telescope->getDescription() }}</td>
                                    <td>{{ $eyepiece->calculateMagnification($telescope) }}x</td>
                                    <td>{{ $eyepiece->calculateTrueFoV($telescope) }}°</td>
                                    <td>{{ $eyepiece->calculateExitPupil($telescope) }} mm</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @if (count($telescopes) === 0)
                        <div style="text-align: center;">
                            <a href="/telescope/create" class="btn btn-success btn-xl">Add Telescope</a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
