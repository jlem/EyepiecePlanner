@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add A Telescope</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/telescope') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aperture') ? ' has-error' : '' }}">
                                <label for="aperture" class="col-md-4 control-label">Aperture (mm)</label>

                                <div class="col-md-6">
                                    <input id="aperture" type="text" class="form-control" name="aperture" value="{{ old('aperture') }}" required>

                                    @if ($errors->has('aperture'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aperture') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('focal_length') ? ' has-error' : '' }}">
                                <label for="focal_length" class="col-md-4 control-label">Focal Length (mm)</label>

                                <div class="col-md-6">
                                    <input id="focal_length" type="text" class="form-control" name="focal_length" value="{{ old('focal_length') }}" required>

                                    @if ($errors->has('focal_length'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('focal_length') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('max_magnification') ? ' has-error' : '' }}">
                                <label for="max_magnification" class="col-md-4 control-label">Max magnification per inch (usually 50x for excellent optics)</label>

                                <div class="col-md-6">
                                    <input id="max_magnification" type="text" class="form-control" name="max_magnification" value="{{ old('max_magnification') }}" required>

                                    @if ($errors->has('max_magnification'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('max_magnification') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Add Telescope
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
