<template>
    <div>
        <h1>{{ eyepiece.focal_length }}mm {{ eyepiece.manufacturer_name }} {{ eyepiece.product_name }}</h1>
        <info-set class="eyepiece-info" :cards="eyepieceInfo" :showBorder="true"></info-set>
        <h2 class="telescope-eyepiece-calculations">Compare Telescopes</h2>
        <telescopes-table :telescopes="telescopes" :eyepiece="eyepiece"></telescopes-table>
    </div>
</template>
<style lang="sass">
    .telescope-eyepiece-calculations {
        margin-top: 100px;
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