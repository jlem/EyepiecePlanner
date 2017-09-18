<template>
    <div>
        <h1>{{ eyepiece.focal_length }}mm {{ eyepiece.manufacturer_name }} {{ eyepiece.product_name }}</h1>
        <ul class="tab-list">
            <li class="tab active-tab">Eyepiece Information</li>
        </ul>
        <info-set class="eyepiece-info" :cards="eyepieceInfo"></info-set>
        <ul class="tab-list">
            <li class="tab active-tab">Eyepiece Telescope Calculations</li>
        </ul>
        <telescopes-table :telescopes="telescopes" :eyepiece="eyepiece"></telescopes-table>
    </div>
</template>
<style lang="sass">
    .eyepiece-info {
        margin-bottom: 100px;
    }
</style>
<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters } from 'vuex';

    export default {
        props: ['id'],
        computed: {
            eyepiece () {
                return window.eyepieces.find(eyepiece => eyepiece.id === +this.id);
            },
            eyepieceInfo () {
                return [
                    { label: 'Focal Length', value: this.eyepiece.focal_length + 'mm' },
                    { label: 'Apparent Field of View', value: this.eyepiece.apparent_field + '°' },
                    { label: 'Eye Relief', value: this.eyepiece.eye_relief + 'mm' },
                    { label: 'Field Stop', value: this.eyepiece.field_stop ? this.eyepiece.field_stop + 'mm' : 'N/A' },
                    { label: 'Barrel Size', value: this.eyepiece.barrel_size + '"' }
                ];
            },
            ...mapGetters([
                'telescopes'
            ])
        }
    }
</script>