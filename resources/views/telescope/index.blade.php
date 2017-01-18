@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Heading -->

        <div>
            <a class="pull-right btn btn-primary" href="/telescope/create">Add Telescope</a>
            <h1>My Telescopes</h1>
        </div>


        <!-- Telescope List -->

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Aperture (mm)</th>
                        <th>Focal Length (mm)</th>
                    </tr>
                    @foreach($telescopes as $telescope)
                        <tr>
                            <td width="50%"><a href="/telescope/{{ $telescope->getID() }}">{{ $telescope->getName() }}</a></td>
                            <td width="25%">{{ $telescope->getAperture() }}</td>
                            <td width="25%">{{ $telescope->getFocalLength() }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
