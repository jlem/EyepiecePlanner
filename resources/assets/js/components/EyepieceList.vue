<template>
    <div>
        <telescope-form :changes="onTelescopeChange" :telescopes="telescopes"></telescope-form>
        <eyepiece-table :eyepieces="computedEyepieces" :telescope="selectedTelescope"></eyepiece-table>
    </div>
</template>

<script type="text/ecmascript-6">
    'use strict';

    import telescopeUtils from "../telescope-utils";
    import { debounce } from "lodash";

    let setTelescope = function (telescope) {
        this.selectedTelescope = telescope;
    };

    let computeEyepieces = function () {
        let eyepieces = this.isComparing ? this.selectedEyepieces : this.eyepieces;
        this.computedEyepieces = telescopeUtils.computeEyepieceProperties(eyepieces, this.selectedTelescope);
    };

    // View Model
    export default {
        props: ['eyepieces', 'telescopes'],
        data: function () {
            return {
                computedEyepieces: []
            };
        },
        created: function () {
            setTelescope.call(this, telescopes[0]);
            computeEyepieces.call(this);
        },
        methods: {
            onTelescopeChange: debounce(function (telescope) {
                setTelescope.call(this, telescope);
                computeEyepieces.call(this);
            }, 100)
        }
    };
</script>