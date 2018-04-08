@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Edit {{ $eyepiece->getDescription() }}
                        <form style="float: right" method="POST" action="{{ url('/eyepiece/'.$eyepiece->getID()) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/eyepiece/'.$eyepiece->getID()) }}">
                            <input type="hidden" name="_method" value="PUT" />

                            @include('eyepiece.create-edit-form')

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Eyepiece
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
