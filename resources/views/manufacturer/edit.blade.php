@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit {{ $manufacturer->getName() }} Details</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/manufacturer/'.$manufacturer->getID()) }}">
                            <input type="hidden" name="_method" value="PUT" />
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $manufacturer->getName() }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Manufacturer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Product Lines
                        <div class="pull-right">
                            <a class="btn btn-primary btn-xs" href="/product-line/create?manufacturer={{ $manufacturer->getID() }}">Add Product Line</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                            </tr>
                            @foreach($manufacturer->getProductLines() as $productLine)
                                <tr>
                                    <td width=100%">{{ $productLine->getName() }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
