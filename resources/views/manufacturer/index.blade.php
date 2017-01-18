@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manufacturers
                        <div class="pull-right">
                            <a class="btn btn-primary btn-xs" href="/manufacturer/create">Add Manufacturer</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                            </tr>
                            @foreach($manufacturers as $manufacturer)
                                <tr>
                                    <td width="100%"><a href="/manufacturer/{{ $manufacturer->getID() }}">{{ $manufacturer->getName() }}</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
