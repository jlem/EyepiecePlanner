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
                <div class="panel-body">
                    <form v-cloak>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Aperture (mm)</label>
                                <input type="text" class="form-control" v-model="telescope.aperture" />
                            </div>
                            <div class="form-group">
                                <label>Focal Length (mm)</label>
                                <input type="text" class="form-control" v-model="telescope.focal_length" />
                            </div>
                            <div class="form-group">
                                <label>Max Magnification Per Inch <em>(usually 50x for excellent optics)</em></label>
                                <input type="text" class="form-control" v-model="telescope.max_magnification" />
                            </div>
                            <div class="form-group">
                                <label>Max Useful Magnification</label>
                                <input type="text" class="form-control" v-bind:value="calculateMaxMagnification(telescope) | numberFormat(2) | mag" disabled />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Your dilated pupil diameter (mm)</label>
                                <input type="text" class="form-control" v-model="telescope.max_pupil" />
                            </div>
                            <div class="form-group">
                                <label>Lowest "Useful" Magnification</label>
                                <input type="text" class="form-control" v-bind:value="calculateLowestMagnification(telescope) | numberFormat(2) | mag" disabled />
                            </div>
                            <div>
                                <p><em>Use the chart below for reference. Will be used to calculate lowest useful magnification - the point at which light is wasted because the exit pupil is too large.</em></p>
                                <dl class="dl-horizontal col-md-6">
                                    <dt>Age 20</dt>
                                    <dd>8 mm</dd>
                                    <dt>Age 30</dt>
                                    <dd>7 mm</dd>
                                    <dt>Age 40</dt>
                                    <dd>6 mm</dd>
                                    <dt>Age 50</dt>
                                    <dd>5 mm</dd>
                                </dl>
                                <dl class="dl-horizontal col-md-6">
                                    <dt>Age 60</dt>
                                    <dd>4.1 mm</dd>
                                    <dt>Age 70</dt>
                                    <dd>3.2 mm</dd>
                                    <dt>Age 80</dt>
                                    <dd>2.5 mm</dd>
                                </dl>
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
                               v-on:keyUp="search(query)" />
                        <div v-cloak v-if="searchResults.length" class="search-results">
                            <div class="selection-tools">
                                <button v-on:click="close()" type="button" class="btn btn-xs btn-success pull-right">Done</button>
                                <button v-if="selectedEyepieces.length" v-on:click="clearSelection()" type="button" class="btn btn-xs btn-danger">
                                    Clear Selection <span class="badge">@{{ selectedEyepiecesMap.length }}</span>
                                </button>
                            </div>
                            <div class="search-result"
                                 v-for="eyepiece in searchResults"
                                 v-bind:class="{ selected: isSelected(selectedEyepiecesMap, eyepiece) }"
                                 v-on:click="select(eyepiece, $event)">
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
                                <span v-cloak>@{{ calculateMagnification(eyepiece, selectedTelescope) | numberFormat(2) | mag}}</span>
                            </td>
                            <td v-bind:class="{ 'warning-magnification': isExitPupilTooLarge(eyepiece, telescope) }">
                                <span v-cloak>@{{ calculateExitPupil(eyepiece, selectedTelescope) | numberFormat(2) | mm}}</span>
                            </td>
                            <td><span v-cloak>@{{ calculateTrueFoV(eyepiece, selectedTelescope) | numberFormat(2) | deg}}</span></td>
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
        // Data
        var eyepieces = JSON.parse('{!! $eyepieces !!}');

        var telescope = {
            focal_length: 2000,
            aperture: 400,
            max_magnification: 50,
            max_pupil: 7
        };


        // Formatters
        var append = function (append, value) {
            return value ? value + append : null;
        };

        var numberFormat = function (value, precision) {
            return parseFloat(value.toFixed(precision));
        };


        // Search
        var getEyepieceDescription = function (eyepiece) {
            return eyepiece.manufacturer_name + ' ' + eyepiece.product_name + ' ' + eyepiece.focal_length + 'mm ';
        };

        var search = function (eyepieces, query) {
            if (!query) {
                return [];
            }

            return eyepieces.filter(function (eyepiece) {
                return getEyepieceDescription(eyepiece).toLowerCase().indexOf(query.toLowerCase()) > -1;
            });
        };

        var isSelected = function (selectedEyepiecesMap, eyepiece) {
            return selectedEyepiecesMap.indexOf(eyepiece.id) > -1;
        };


        // Telescope functions
        var isSelectedTelescope = function (selectedTelescope, telescope) {
            return selectedTelescope.description === telescope.description;
        };


        // Telescope calculations
        var calculateMagnification = function (eyepiece, telescope) {
            return telescope.focal_length / eyepiece.focal_length;
        };

        var calculateTrueFoV = function (eyepiece, telescope) {
            return eyepiece.apparent_field / calculateMagnification(eyepiece, telescope);
        };

        var calculateExitPupil = function (eyepiece, telescope) {
            return telescope.aperture / calculateMagnification(eyepiece, telescope);
        };

        var calculateMaxMagnification = function (telescope) {
            return telescope.aperture / 25.4 * telescope.max_magnification;
        };

        var calculateLowestMagnification = function (telescope) {
            return telescope.aperture / telescope.max_pupil;
        };

        var isMagnificationTooHigh = function (eyepiece, telescope) {
            return calculateMagnification(eyepiece, telescope) > calculateMaxMagnification(telescope);
        };

        var isExitPupilTooLarge = function (eyepiece, telescope) {
            return calculateExitPupil(eyepiece, telescope) > telescope.max_pupil;
        };


        // View Model
        new Vue({
            el: '#comparison',
            data: {
                eyepieces: eyepieces,
                selectedEyepieces: [],
                selectedEyepiecesMap: [],
                telescope: telescope,
                selectedTelescope: telescope,
                searchResults: [],
                query: null
            },
            methods: {
                calculateMagnification: calculateMagnification,
                calculateTrueFoV: calculateTrueFoV,
                calculateExitPupil: calculateExitPupil,
                calculateMaxMagnification: calculateMaxMagnification,
                calculateLowestMagnification: calculateLowestMagnification,
                isMagnificationTooHigh: isMagnificationTooHigh,
                isExitPupilTooLarge: isExitPupilTooLarge,
                getEyepieceDescription: getEyepieceDescription,
                isSelectedTelescope: isSelectedTelescope,
                selectTelescope: function (telescope) {
                    this.selectedTelescope = telescope;
                },
                isSelected: isSelected,
                select: function (eyepiece, event) {
                    isSelected(this.selectedEyepiecesMap, eyepiece)
                            ? this.removeSelection(eyepiece)
                            : this.addSelection(eyepiece)
                },
                addSelection: function (eyepiece) {
                    this.selectedEyepieces.push(eyepiece);
                    this.selectedEyepiecesMap.push(eyepiece.id);
                },
                removeSelection: function (eyepiece) {
                    var index = this.selectedEyepiecesMap.indexOf(eyepiece.id);
                    this.selectedEyepieces.splice(index, 1);
                    this.selectedEyepiecesMap.splice(index, 1);
                },
                clearSelection: function () {
                    this.selectedEyepieces = [];
                    this.selectedEyepiecesMap = [];
                },
                close: function () {
                    this.clearSearch();
                },
                search: function (query) {
                    this.searchResults = search(eyepieces, query);
                },
                clearSearch: function () {
                    this.query = null;
                    this.search(this.query);
                }
            },
            filters: {
                append: append,
                mm: _.partial(append, ' mm'),
                deg: _.partial(append, '°'),
                mag: _.partial(append, 'x'),
                numberFormat: numberFormat
            }
        });
    </script>
@endsection
