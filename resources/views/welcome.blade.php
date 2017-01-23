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
                <table class="table table-bordered">
                    <tr>
                        <th>Manufacturer</th>
                        <th>Product Line</th>
                        <th>Focal Length</th>
                        <th>Apparent Field</th>
                        <th>Field Stop</th>
                        <th>Eye Relief</th>
                        <th>Barrel Size</th>
                    </tr>
                    @foreach($eyepieces as $eyepiece)
                        <tr>
                            <td width="15%">{{ $eyepiece->getManufacturer()->getName() }}</td>
                            <td width="14%">{{ $eyepiece->getProductLine()->getName() }}</td>
                            <td width="14%"><a href="/eyepiece/{{ $eyepiece->getID() }}">{{ $eyepiece->getFocalLength() }} mm</a></td>
                            <td width="14%">{{ $eyepiece->getApparentField() }}°</td>
                            <td width="14%">{{ $eyepiece->getFieldStop() }} mm</td>
                            <td width="14%">{{ $eyepiece->getEyeRelief() }} mm</td>
                            <td width="14%">{{ $eyepiece->getBarrelSize() }}"</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
