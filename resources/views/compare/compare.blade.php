@extends('layouts.app')

@section('content')
    <div class="container" id="comparison">

        <!-- Heading -->
        <div>
            <h1>Eyepiece Comparison</h1>
        </div>

        <!-- Telescope Information -->
        <h3>1. Add telescope information</h3>
        <div class="row">
            <div class="panel">
                <div class="panel-body comparison-telescope-form">
                    <form v-cloak>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Aperture (mm)</label>
                                <input type="text" class="form-control" v-model="telescope.aperture" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Focal Length (mm)</label>
                                <input type="text" class="form-control" v-model="telescope.focal_length" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Pupil size (mm) <a href="#" v-on:click="togglePupilReference()">(chart)</a></label>
                                <input type="text" class="form-control" v-model="telescope.max_pupil" />
                            </div>
                            <div class="pupil-reference" v-if="pupilReference" v-on:click="togglePupilReference()" v-cloak>
                                <dl class="dl-horizontal">
                                    <dt>Age 20</dt>
                                    <dd>8 mm</dd>
                                    <dt>Age 30</dt>
                                    <dd>7 mm</dd>
                                    <dt>Age 40</dt>
                                    <dd>6 mm</dd>
                                    <dt>Age 50</dt>
                                    <dd>5 mm</dd>
                                    <dt>Age 60</dt>
                                    <dd>4.1 mm</dd>
                                    <dt>Age 70</dt>
                                    <dd>3.2 mm</dd>
                                    <dt>Age 80</dt>
                                    <dd>2.5 mm</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Max Magnification Per Inch</label>
                                <input type="text" class="form-control" v-model="telescope.max_magnification" />
                            </div>
                        </div>
                        {{--<div class="col-md-4">--}}
                            {{--<div class="form-group">--}}
                                {{--<label>Max Useful Magnification</label>--}}
                                {{--<input type="text" class="form-control" v-bind:value="calculateMaxMagnification(telescope) | numberFormat(2) | mag" disabled />--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                            {{--<div class="form-group">--}}
                                {{--<label>Lowest "Useful" Magnification</label>--}}
                                {{--<input type="text" class="form-control" v-bind:value="calculateLowestMagnification(telescope) | numberFormat(2) | mag" disabled />--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </form>
                </div>
            </div>
        </div>

        <!-- Eyepiece Search -->
        <h3>2. Search for eyepieces to compare</h3>
        <div class="row">
            <div class="panel">
                <div class="panel-body">

                    <!-- Eyepiece Search Field -->
                    <div class="search">
                        <i class="search-icon glyphicon glyphicon-search"></i>
                        <input type="text"
                               name="query"
                               placeholder="Examples: 'Delite', 'Explore Scientific', '30mm'"
                               class="form-control input-lg"
                               v-model="query"
                               v-on:keyUp="search(eyepieces, query)" />
                        <div v-cloak v-if="searchResults.length" class="search-results">
                            <div class="selection-tools">
                                <button v-on:click="clearSearch()" type="button" class="btn btn-success pull-right">Done</button>
                                <button v-if="selectedEyepieces.length" v-on:click="clearSelection()" type="button" class="btn btn-danger">
                                    Clear Selection <span class="badge">@{{ selectedEyepieces.length }}</span>
                                </button>
                            </div>
                            <div class="search-result"
                                 v-for="eyepiece in searchResults"
                                 v-bind:class="{ selected: isSelected(selectedEyepieces, eyepiece) }"
                                 v-on:click="select(selectedEyepieces, eyepiece)">
                                @{{ getEyepieceDescription(eyepiece) }}
                            </div>
                        </div>
                    </div>

                    <!-- Eyepiece List -->
                    <eyepiece-list v-if="selectedEyepieces.length" :eyepieces="selectedEyepieces" :telescope="telescope"></eyepiece-list>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        window.eyepieces = JSON.parse('{!! $eyepieces !!}');
        window.telescope = {
            focal_length: 2000,
            aperture: 400,
            max_magnification: 50,
            max_pupil: 7
        };
    </script>
    <script src="/js/eyepiece-form.js"></script>
@endsection
