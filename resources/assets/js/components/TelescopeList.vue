<template>
    <div class="telescope-list">
        <ul class="tab-list">
            <li :class="[{ 'active-tab': telescope.id === selectedTelescope.id }, 'tab']"
                v-for="(telescope, index) in telescopes"
                @click="selectTelescope(telescope)">
                    <span>{{ telescope.name }}</span>
                    <span v-if="telescope.id === selectedTelescope.id" class="action-buttons">
                        <span @click="openCreateEditModal(telescope)" class="tab-action-button">
                            <i class="glyphicon glyphicon-pencil" title="Edit Telescope" alt="Edit Telescope"></i>
                        </span>
                        <span @click="removeTelescope(telescope, $event)" class="tab-action-button">
                            <i class="glyphicon glyphicon-remove" title="Delete Telescope" alt="Delete Telescope"></i>
                        </span>
                    </span>
            </li><li class="tab add-tab" @click="openCreateEditModal()">
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

    .telescope-list .active-tab {
        padding-right: 10px;
    }

    .telescope-info {
        display: flex;
    }

    .telescope-info-item {
        font-size: 24px;
        flex: 1;
        text-align: center;
        margin-right: 5px;
        color: #fff;
        padding: 20px;
        background: linear-gradient(rgba(200, 165, 220, 0.15), rgba(200, 165, 220, 0.06));

        &:last-of-type {
            margin-right: 0;
         }

        .epp-button {
            background: $primary-gradient-semitransparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;

            &:hover {
                 background: $primary-gradient-semitransparent-hover;
             }

            &:first-of-type {
                margin-right: 20px;
             }
        }
    }

    .action-buttons {
        margin-left: 25px;
    }

    .tab-action-button {
        background: linear-gradient(rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.1));
        padding: 5px 8px;
        font-size: 13px;
        border-radius: 3px;
        cursor: pointer;
        color: $primary-light;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.1);

        &:hover {
            color: #fff;
             background: linear-gradient(rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.2));
         }
    }

    .action-item {
        display: flex;
    }

    .telescope-info-item-label {
        font-size: 18px;
        font-weight: bold;
        color: $primary;
    }

    .telescope-list {
        margin-bottom: 50px;
    }
    
    .add-tab {
        background: $primary-gradient-semitransparent;
        &:hover {
            background: $primary-gradient-semitransparent-hover;
         }
    }
</style>
<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters, mapActions } from 'vuex';
    import formatters from '../formatters';
    import telescopeHttpService from '../services/telescope-http-service';
    import utils from '../utils';

    export default {
        props: ['telescopes', 'selectedTelescope'],
        methods: {
            removeTelescope: function (telescope, $event) {
                $event.stopImmediatePropagation(); // prevent the click from falling through and selecting the telescope we just removed
                this.$store.dispatch('removeTelescope', telescope);
                this.$store.dispatch('selectTelescope', this.telescopes[this.telescopes.length - 1]);
                if (this.auth.isAuthenticated) {
                    telescopeHttpService.remove(telescope).then(() => {});
                }
            },
            selectTelescope: function (telescope) {
                this.$store.dispatch('selectTelescope', telescope);
                this.$emit('onTelescopeSelected', telescope);
            },
            ...mapActions([
                'openCreateEditModal'
            ])
        },
        computed: {
            ...mapGetters([
                'auth',
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
                    max_eyepiece_size: matches[3],
                    id: utils.randomString(5)
                };

                this.saveTelescope(telescope);
            }

            this.selectTelescope(telescope);
        }
    };
</script>
