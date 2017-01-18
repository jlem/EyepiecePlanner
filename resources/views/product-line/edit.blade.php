@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit {{ $eyepiece->getName() }}</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/eyepiece/'.$eyepiece->getID()) }}">
                            <input type="hidden" name="_method" value="PUT" />
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('manufacturer_id') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Manufacturer</label>

                                <div class="col-md-6">
                                    <select id="manufacturer_id" name="manufacturer_id">
                                        @foreach($manufacturers as $manufacturer)
                                            <option value="{{ $manufacturer->getID() }}">{{ $manufacturer->getName() }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('manufacturer_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('manufacturer_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $eyepiece->getName() }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('focal_length') ? ' has-error' : '' }}">
                                <label for="focal_length" class="col-md-4 control-label">Focal Length (mm)</label>

                                <div class="col-md-6">
                                    <input id="focal_length" type="text" class="form-control" name="focal_length" value="{{ $eyepiece->getFocalLength() }}" required>

                                    @if ($errors->has('focal_length'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('focal_length') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

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
