<template>
    <div>
        <!-- Eyepiece List -->
        <table v-cloak class="table table-bordered">
            <thead>
                <tr>
                    <th>Manufacturer</th>
                    <th>Product Line</th>
                    <th>Focal Length</th>
                    <th v-if="telescope">Magnification<span class="asterisk">*</span></th>
                    <th v-if="telescope">Exit Pupil<span class="asterisk">*</span></th>
                    <th v-if="telescope">True FoV<span class="asterisk">*</span></th>
                    <th>Apparent Field</th>
                    <th>Eye Relief</th>
                    <th>Barrel Size</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(eyepiece, index) in selectedEyepieces" v-bind:class="{ warning: showWarning(eyepiece, telescope) }">
                    <td><span v-cloak>{{ eyepiece.manufacturer_name }}</span></td>
                    <td><span v-cloak>{{ eyepiece.product_name }}</span></td>
                    <td><span v-cloak>{{ eyepiece.focal_length | mm}}</span></td>
                    <td v-if="telescope" v-bind:class="{ 'warning-magnification': isMagnificationTooHigh(eyepiece, telescope) }">
                        <span v-cloak>{{ calculateMagnification(eyepiece, telescope) | numberFormat(2) | mag}}</span>
                    </td>
                    <td v-if="telescope" v-bind:class="{ 'warning-magnification': isExitPupilTooLarge(eyepiece, telescope) }">
                        <span v-cloak>{{ calculateExitPupil(eyepiece, telescope) | numberFormat(2) | mm}}</span>
                    </td>
                    <td v-if="telescope"><span v-cloak>{{ calculateTrueFoV(eyepiece, telescope) | numberFormat(2) | deg}}</span></td>
                    <td><span v-cloak>{{ eyepiece.apparent_field | deg }}</span></td>
                    <td><span v-cloak>{{ eyepiece.eye_relief | mm }}</span></td>
                    <td><span v-cloak>{{ eyepiece.barrel_size }}</span></td>
                </tr>
            </tbody>
        </table>
        <div v-if="telescope" >
            <span class="asterisk">*</span> Values computed for your selected telescope. All other values are properties of the eyepiece.
        </div>
    </div>
</template>


<script type="text/ecmascript-6">
    import telescopeUtilities from "../telescope-utils";
    import formatters from "../formatters";
    import utils from "../utils";

    'use strict';

    // Search
    const search = (eyepieces, query) => (!query) ? [] : eyepieces.filter(eyepiece => telescopeUtilities.getEyepieceDescription(eyepiece).toLowerCase().indexOf(query.toLowerCase()) > -1);
    const showWarning = (eyepiece, telescope) => (!telescope) ? false :  telescopeUtilities.isMagnificationTooHigh(eyepiece, telescope) || telescopeUtilities.isExitPupilTooLarge(eyepiece, telescope);

    // View Model
    export default {
        props: ['eyepieces', 'telescope'],
        data: function () {
            return {
                searchResults: [],
                pupilReference: false,
                query: null
            }
        },
        computed: {
            selectedEyepieces: function () {
                return this.eyepieces;
            }
        },
        methods: {
            calculateMagnification: telescopeUtilities.calculateMagnification,
            calculateTrueFoV: telescopeUtilities.calculateTrueFoV,
            calculateExitPupil: telescopeUtilities.calculateExitPupil,
            calculateMaxMagnification: telescopeUtilities.calculateMaxMagnification,
            calculateLowestMagnification: telescopeUtilities.calculateLowestMagnification,
            isMagnificationTooHigh: telescopeUtilities.isMagnificationTooHigh,
            isExitPupilTooLarge: telescopeUtilities.isExitPupilTooLarge,
            showWarning,
        },
        filters: formatters
    };
</script>