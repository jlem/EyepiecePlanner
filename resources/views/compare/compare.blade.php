@extends('layouts.app')

@section('content')
    <div class="container" id="comparison">

        <!-- Telescope Information -->
        <div class="row">
            <div class="comparison-telescope-form">
                <form v-cloak autocomplete="off">
                    <div class="col-md-3">
                        <div class="form-group animated-field">
                            <input type="text" role="search"  v-model="telescope.aperture" required autocomplete="off"/>
                            <label>Telescope Aperture (mm)</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group animated-field">
                            <input type="text" role="search" v-model="telescope.focal_length" required autocomplete="off" />
                            <label>Telescope Focal Length (mm)</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group animated-field">
                            <input type="text" role="search" v-model="telescope.max_pupil" required autocomplete="off" />
                            <label>Pupil size (mm) <a href="#" v-on:click="togglePupilReference()">(chart)</a></label>
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
                        <div class="form-group animated-field">
                            <input type="text" role="search" v-model="telescope.max_magnification" required autocomplete="off" />
                            <label>Max Magnification Per Inch</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Eyepiece Search -->
        <div class="row eyepiece-comparison">
            <div class="col-xs-12">
                <!-- Eyepiece Search Field -->
                <div class="animated-field">
                    <input type="text"
                           name="query"
                           required
                           role="search"
                           class="search-field"
                           v-model="query"
                           v-on:keyUp="search(eyepieces, query)" />
                    <label>
                        <i class="search-icon glyphicon glyphicon-search"></i>
                        Search for eyepieces to compare...
                    </label>
                    <div class="search-example">Examples: <em>"Delite"</em>, <em>"Explore Scientific"</em>, <em>"30mm"</em></div>
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
            </div>
                <!-- Eyepiece List -->
            <div class="col-md-12">
                <eyepiece-list v-if="selectedEyepieces.length" :eyepieces="selectedEyepieces" :telescope="telescope"></eyepiece-list>
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
