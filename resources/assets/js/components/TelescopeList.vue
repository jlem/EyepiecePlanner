<template>
    <div class="telescope-list">
        <ul class="tab-list">
            <li :class="[{ 'active-tab': telescope.name === selectedTelescope.name }, 'tab']"
                v-for="(telescope, index) in telescopes"
                @click="selectTelescope(telescope)">
                    <div>{{ telescope.name }}</div>
                    <i v-if="telescope.is_custom && telescope.name === selectedTelescope.name"
                       v-on:click="removeTelescope(telescope, $event)"
                       class="remove-telescope glyphicon glyphicon-remove-circle"></i>
            </li><li class="add-button" @click="showEditModal()">
                <i class="glyphicon glyphicon-plus"></i> Add Telescope
            </li>
        </ul>
        <div class="telescope-info">
            <div class="telescope-info-item">
                <div class="telescope-info-item-label">Aperture</div>
                {{ selectedTelescope.aperture }}mm
            </div>
            <div class="telescope-info-item">
                <div class="telescope-info-item-label">Focal Ratio</div>
                F/{{ selectedTelescope.focal_ratio }}
            </div>
            <div class="telescope-info-item">
                <div class="telescope-info-item-label">Focal Length</div>
                {{ selectedTelescope.focal_length }}mm
            </div>
            <div class="telescope-info-item">
                <div class="telescope-info-item-label">Max Eyepiece Size</div>
                {{ selectedTelescope.max_eyepiece_size }}"
            </div>
        </div>
    </div>
</template>
<style lang="sass">
    @import "../../sass/_variables.scss";

    .telescope-info {
        display: flex;
    }

    .telescope-info-item {
        font-size: 24px;
        flex: 1;
        text-align: center;
        margin-right: 5px;
        color: #fff;
        padding-top: 20px;
        padding-bottom: 20px;
        background: linear-gradient(rgba(200, 165, 220, 0.15), rgba(200, 165, 220, 0.06));

        &:last-of-type {
            margin-right: 0;
         }
    }

    .telescope-info-item-label {
        font-size: 18px;
        font-weight: bold;
        color: $primary;
    }

    .telescope-list {
        margin-bottom: 50px;
    }
    
    .add-button {
        float: right;
        cursor: pointer;
        display: inline-block;
        background: $success-gradient;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4);
        color: #fff;
        margin-top: 2px;
        padding: 7px 15px 5px 15px;
        font-size: 18px;
        vertical-align: middle;
        border-radius: 3px;
        font-weight: bold;

        &:hover {
            background: $success-gradient-hover;
         }
    }
</style>
<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters, mapActions } from 'vuex';
    import formatters from '../formatters';

    export default {
        props: ['telescopes', 'selectedTelescope'],
        methods: {
            removeTelescope: function (telescope, $event) {
                $event.stopImmediatePropagation(); // We have to do this because front-end development is a wasteland
                this.$store.dispatch('removeTelescope', telescope);
                this.$store.dispatch('selectTelescope', this.telescopes[this.telescopes.length - 1]);
            },
            ...mapActions([
                'selectTelescope',
                'showEditModal'
            ])
        },
        filters: formatters,
        created: function () {
            const TELESCOPE_REGEX = /t=(.+),(.+),(.+)?;/;
            let hash = window.location.hash;
            let telescope = this.telescopes[0];

            if (TELESCOPE_REGEX.test(hash)) {
                let matches = hash.match(TELESCOPE_REGEX);

                // Create a new telescope from the hash values
                telescope = {
                    name: 'Custom Telescope',
                    aperture: +matches[1],
                    focal_ratio: +matches[2],
                    focal_length: +matches[1] * +matches[2],
                    max_eyepiece_size: matches[3]
                };

                this.saveTelescope(telescope);
            }

            this.selectTelescope(telescope);
        }
    };
</script>
