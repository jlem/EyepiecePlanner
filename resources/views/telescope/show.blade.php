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
                        </dl>
                    </div>
                </div>
            </div>
        </div>


        <!-- Eyepiece Telescope Calculations -->

        <div class="row">
            <div class="col-md-12">
                <h3>Eyepiece Calculations</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Manufacturer</th>
                        <th>Product Line</th>
                        <th>Focal Length</th>
                        <th>Magnification<span class="asterisk">*</span></th>
                        <th>Exit Pupil<span class="asterisk">*</span></th>
                        <th>True FoV<span class="asterisk">*</span></th>
                        <th>Apparent FoV</th>
                        <th>Field Stop</th>
                        <th>Eye Relief</th>
                        <th>Barrel Size</th>
                    </tr>
                    @foreach($eyepieces as $eyepiece)
                        <tr>
                            <td width="15%">{{ $eyepiece->getManufacturer()->getName() }}</td>
                            <td width="10%">{{ $eyepiece->getProductLine()->getName() }}</td>
                            <td width="10%"><a href="/eyepiece/{{ $eyepiece->getID() }}">{{ append($eyepiece->getFocalLength(), ' mm') }}</a></td>
                            <td width="10%">{{ append($eyepiece->calculateMagnification($selectedTelescope), 'x') }}</td>
                            <td width="10%">{{ append($eyepiece->calculateExitPupil($selectedTelescope), ' mm') }}</td>
                            <td width="9%">{{ append($eyepiece->calculateTrueFoV($selectedTelescope), '°') }}</td>
                            <td width="9%">{{ append($eyepiece->getApparentField(), '°') }}</td>
                            <td width="9%">{{ append($eyepiece->getFieldStop(), ' mm') }}</td>
                            <td width="9%">{{ append($eyepiece->getEyeRelief(), ' mm') }}</td>
                            <td width="9%">{{ append($eyepiece->getBarrelSize(), '"') }}</td>
                        </tr>
                    @endforeach
                </table>
                <span class="asterisk">*</span> Values computed for your selected telescope. All other values are properties of the eyepiece.
            </div>
        </div>
    </div>
@endsection
