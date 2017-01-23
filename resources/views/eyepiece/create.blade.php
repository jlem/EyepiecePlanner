@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add An Eyepiece</div>
                    <div class="panel-body">
                        <form id="eyepiece-form" class="form-horizontal" role="form" method="POST" action="{{ url('/eyepiece') }}">

                            @include('eyepiece.create-edit-form')

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <input id="addanother" type="checkbox" name="addanother" @if (Session::has('add-eyepiece')) checked="checked" @endif value="1" />
                                    <label for="addanother">Add another?</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Add Eyepiece
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
@section('page-script')
    <script src="/js/eyepiece-form.js"></script>
@endsection
