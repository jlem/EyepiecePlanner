@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Heading -->

        <div>
            <a class="pull-right btn btn-success" href="/telescope/create">Add Telescope</a>
            <h1>My Telescopes</h1>
        </div>

        <!-- Description -->

        @if (Auth::guest())
            <div style="margin-bottom: 30px;">
                <p>Your telescopes will be saved in your browser's cookies, meaning they could be lost if you ever clear those cookies.</p>
                <p>If you <a href="/register">register an account</a>, your telescopes will be saved in the database instead, and won't be lost if you clear your cookies.</p>
            </div>
        @endif


        <!-- Telescope List -->

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Aperture (mm)</th>
                        <th>Focal Length (mm)</th>
                        <th></th>
                    </tr>
                    @foreach($telescopes as $telescope)
                        <tr>
                            <td width="35%"><a href="/telescope/{{ $telescope->getID() }}">{{ $telescope->getName() }}</a></td>
                            <td width="25%">{{ $telescope->getAperture() }}</td>
                            <td width="25%">{{ $telescope->getFocalLength() }}</td>
                            <td width="15%">
                                <form action="/telescope/{{ $telescope->getID() }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE" />
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                    <a href="/telescope/{{ $telescope->getID() }}/edit"  class="btn btn-primary btn-xs">Edit</a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
