<template>
    <div>
        <!-- Eyepiece List -->
        <table v-cloak class="eyepiece-table">
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
                    <th>Field Stop</th>
                    <th>Barrel Size</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(eyepiece, index) in eyepieces">
                    <td>{{ eyepiece.manufacturer_name }}</td>
                    <td>{{ eyepiece.product_name }}</td>
                    <td>{{ eyepiece.focal_length | mm }}</td>
                    <td v-if="telescope" v-bind:class="{ 'warning-magnification': isMagnificationTooHigh(eyepiece, telescope) }">
                        {{ calculateMagnification(eyepiece, telescope) | numberFormat(2) | mag }}
                    </td>
                    <td v-if="telescope" v-bind:class="{ 'warning-magnification': isExitPupilTooLarge(eyepiece, telescope) }">
                        {{ calculateExitPupil(eyepiece, telescope) | numberFormat(2) | mm }}
                    </td>
                    <td v-if="telescope && eyepiece.field_stop">
                        {{ calculateTrueFoVFieldStop(eyepiece, telescope) | numberFormat(2) | deg }}
                    </td>
                    <td v-if="telescope && !eyepiece.field_stop">
                        {{ calculateTrueFoV(eyepiece, telescope) | numberFormat(2) | deg }}<span class="asterisk">†</span>
                    </td>
                    <td>{{ eyepiece.apparent_field | deg }}</td>
                    <td>{{ eyepiece.eye_relief | mm }}</td>
                    <td>{{ eyepiece.field_stop | mm }}</td>
                    <td>{{ eyepiece.barrel_size }}</td>
                </tr>
            </tbody>
        </table>
        <div v-if="telescope" >
            <p><span class="asterisk">*</span> Values computed for your selected telescope. All other values are properties of the eyepiece.</p>
            <p><span class="asterisk">†</span> True FOV computed using less accurate apparent field method</p>
        </div>
    </div>
</template>


<script type="text/ecmascript-6">
    import telescopeUtilities from "../telescope-utils";
    import formatters from "../formatters";
    import utils from "../utils";

    'use strict';

    // View Model
    export default {
        props: ['eyepieces', 'telescope'],
        methods: telescopeUtilities,
        filters: formatters
    };
</script>