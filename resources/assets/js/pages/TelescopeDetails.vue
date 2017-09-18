<template>
    <div>
        <h1>{{ telescope.name }}</h1>
        <info-set :cards="telescopeInfo" :showBorder="true"></info-set>
    </div>
</template>
<style lang="sass"></style>
<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters } from 'vuex';

    // View Model
    export default {
        props: ['id'],
        computed: {
            telescope: function() {
                return this.telescopes.find(t => t.id == this.id);
            },
            telescopeInfo: function () {
                return [
                    { label: 'Aperture', value: this.telescope.aperture + 'mm' },
                    { label: 'Focal Length', value: this.telescope.focal_length + 'mm' },
                    { label: 'Focal Ratio', value: 'F/' + this.telescope.focal_ratio },
                    { label: 'Max Eyepiece Size', value: this.telescope.max_eyepiece_size + '"' }
                ];
            },
            ...mapGetters([
                'telescopes'
            ])
        }
    };
</script>
