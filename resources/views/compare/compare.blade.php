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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Aperture (mm)</label>
                                <input type="text" class="form-control" v-model="telescope.aperture" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Focal Length (mm)</label>
                                <input type="text" class="form-control" v-model="telescope.focal_length" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Your dilated pupil size (mm) <a href="#" v-on:click="togglePupilReference()">(reference)</a></label>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Max Magnification Per Inch</label>
                                <input type="text" class="form-control" v-model="telescope.max_magnification" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Max Useful Magnification</label>
                                <input type="text" class="form-control" v-bind:value="calculateMaxMagnification(telescope) | numberFormat(2) | mag" disabled />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lowest "Useful" Magnification</label>
                                <input type="text" class="form-control" v-bind:value="calculateLowestMagnification(telescope) | numberFormat(2) | mag" disabled />
                            </div>
                        </div>
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
                        <input type="text"
                               name="query"
                               placeholder="Search for eyepieces to compare..."
                               class="form-control input-lg"
                               v-model="query"
                               v-on:keyUp="search(eyepieces, query)" />
                        <div v-cloak v-if="searchResults.length" class="search-results">
                            <div class="selection-tools">
                                <button v-on:click="clearSearch()" type="button" class="btn btn-xs btn-success pull-right">Done</button>
                                <button v-if="selectedEyepieces.length" v-on:click="clearSelection()" type="button" class="btn btn-xs btn-danger">
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

                    <div v-cloak v-if="!selectedEyepieces.length">
                        <p>Examples: <em>"Delite"</em>, <em>"Explore Scientific"</em>, <em>"30mm"</em></p>
                    </div>


                    <!-- Eyepiece List -->
                    <table v-cloak class="table table-bordered">
                        <tr>
                            <th>Manufacturer</th>
                            <th>Product Line</th>
                            <th>Focal Length</th>
                            <th>Magnification<span class="asterisk">*</span></th>
                            <th>Exit Pupil<span class="asterisk">*</span></th>
                            <th>True FoV<span class="asterisk">*</span></th>
                            <th>Apparent Field</th>
                            <th>Eye Relief</th>
                            <th>Field Stop</th>
                            <th>Barrel Size</th>
                        </tr>
                        <tr v-for="(eyepiece, index) in selectedEyepieces" v-bind:class="{ warning: isMagnificationTooHigh(eyepiece, telescope) || isExitPupilTooLarge(eyepiece, telescope) }">
                            <td><span v-cloak>@{{ eyepiece.manufacturer_name }}</span></td>
                            <td><span v-cloak>@{{ eyepiece.product_name }}</span></td>
                            <td><span v-cloak>@{{ eyepiece.focal_length | mm}}</span></td>
                            <td v-bind:class="{ 'warning-magnification': isMagnificationTooHigh(eyepiece, telescope) }">
                                <span v-cloak>@{{ calculateMagnification(eyepiece, telescope) | numberFormat(2) | mag}}</span>
                            </td>
                            <td v-bind:class="{ 'warning-magnification': isExitPupilTooLarge(eyepiece, telescope) }">
                                <span v-cloak>@{{ calculateExitPupil(eyepiece, telescope) | numberFormat(2) | mm}}</span>
                            </td>
                            <td><span v-cloak>@{{ calculateTrueFoV(eyepiece, telescope) | numberFormat(2) | deg}}</span></td>
                            <td><span v-cloak>@{{ eyepiece.apparent_field | deg }}</span></td>
                            <td><span v-cloak>@{{ eyepiece.eye_relief | mm }}</span></td>
                            <td><span v-cloak>@{{ eyepiece.field_stop | mm }}</span></td>
                            <td><span v-cloak>@{{ eyepiece.barrel_size }}</span></td>
                        </tr>
                    </table>
                    <span class="asterisk">*</span> Values computed for your selected telescope. All other values are properties of the eyepiece.
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        window.eyepieces = JSON.parse('{!! $eyepieces !!}');
    </script>
    <script src="/js/eyepiece-form.js"></script>
@endsection
