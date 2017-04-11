@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Profile</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('pupil_size') ? ' has-error' : '' }}">
                                <label for="pupil_size" class="col-md-4 control-label">Pupil Size</label>

                                <div class="col-md-6">
                                    <input id="pupil_size" type="text" class="form-control" name="pupil_size" value="{{ old('pupil_size') ?: Auth::user()->getPupilSize() }}" required>

                                    @if ($errors->has('pupil_size'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('pupil_size') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Profile
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
