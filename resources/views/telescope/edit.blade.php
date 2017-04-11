@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit {{ $telescope->getName() }}</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/telescope/'.$telescope->getID()) }}">
                            <input type="hidden" name="_method" value="PUT" />
                            @include('telescope.create-edit-form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
