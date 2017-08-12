<template>
    <div class="container">
        <ul class="telescopes">
            <li v-bind:class="[{ active: telescope.name === selectedTelescope.name }, 'telescope-tab']"
                v-for="(telescope, index) in telescopes"
                @click="selectTelescope(telescope)">
                {{ telescope.name }}<span class="unsaved-indicator" v-if="telescope.is_custom && telescope.name !== selectedTelescope.name">*</span>
                <i v-if="telescope.is_custom && telescope.name === selectedTelescope.name"
                   v-on:click="removeTelescope(telescope, $event)"
                   class="remove-telescope glyphicon glyphicon-remove-circle"></i>
            </li>
        </ul>
        <button class="btn btn-success" v-on:click="startCreateMode($event)"><i class="glyphicon glyphicon-plus"></i> Add Telescope</button>
        <div class="telescope-form">
            <div class="telescope-form-field">
                <div class="animated-field">
                    <input type="text" role="search" v-model="selectedTelescope.aperture" @input="updateTelescope(selectedTelescope)" required autocomplete="off"/>
                    <label>Telescope Aperture (mm)</label>
                </div>
            </div>
            <div class="telescope-form-field">
                <div class="animated-field">
                    <input type="text" role="search" v-model="selectedTelescope.focal_ratio" @input="updateFocalRatio(selectedTelescope)" required autocomplete="off" />
                    <label>Telescope Focal Ratio</label>
                </div>
            </div>
            <div class="telescope-form-field">
                <div class="animated-field">
                    <input type="text" role="search" v-model="selectedTelescope.focal_length" @input="updateFocalLength(selectedTelescope)" required autocomplete="off" />
                    <label>Telescope Focal Length (mm)</label>
                </div>
            </div>
            <div class="telescope-form-field">
                <div class="animated-field">
                    <select v-model="selectedTelescope.max_eyepiece_size" @change="updateTelescope(selectedTelescope)">
                        <option value=""></option>
                        <option value="1.25">1.25"</option>
                        <option value="2">2"</option>
                        <option value="3">3"</option>
                    </select>
                    <label>Max Eyepiece Size</label>
                </div>
            </div>
        </div>
    </div>
</template>

<style type="text/css">
    .container {
        position: relative;
    }

    .telescope-form {
        background: #3d4044;
        border: 1px solid #34373b;
        border-radius: 3px;
        box-sizing: content-box;
        display: flex;
        margin-bottom: 30px;
    }

    .telescopes {
        display: inline-block;
        position: relative;
        z-index: 1;
        list-style-type: none;
        padding: 0;
        margin: 0;
        top: 3px;
    }

    .telescope-tab {
        display:inline-block;
        margin-right: 5px;
        font-size: 18px;
        border: 1px solid #e2e2e2;
        border-radius: 3px 3px 0 0;
        border-bottom: 0;
        padding: 8px 13px;
        cursor: pointer;
    }

    .telescope-tab.active {
        background: #3d4044;
        border: 1px solid #34373b;
        border-bottom: 3px solid #3d4044;
        color: #fff;
        cursor: default;
    }

    .telescope-tab.active input {
        color: black;
    }

    .unsaved-indicator {
        font-size: 25px;
        font-weight: bold;
        opacity: 0.75;
        color: red;
        line-height: 5px;
    }

    .remove-telescope {
        position: relative;
        margin-left: 8px;
        top: 3px;
        cursor: pointer;
        opacity: 0.5;
    }

    .remove-telescope:hover {
        opacity: 1;
    }

    .animated-field {
        background: #fff;
        border-radius: 3px;
    }

    .telescope-form-field {
        box-sizing: border-box;
        padding: 10px 10px 10px 0;
        border-radius: 3px;
        flex: 1;
    }

    .telescope-form-field input {
        box-shadow: inset 0 0 3px rgba(0,0,0,0.1);
        border-radius: 3px;
    }

    .telescope-form-field:first-of-type {
        padding-left: 10px;
    }
</style>

<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters, mapActions } from 'vuex';

    export default {
        props: ['telescopes'],
        data: function () {
            return {
                isCreateMode: false
            }
        },
        methods: {
            startCreateMode: function ($event) {
                $event.stopImmediatePropagation(); // We have to do this because front-end development is a wasteland
                let name = window.prompt('Give this telescope a name');

                if (!name) {
                    return;
                }

                this.isCreateMode = true;

                let telescope = {
                    name,
                    aperture: 0,
                    focal_ratio: 0,
                    focal_length: 0,
                    max_eyepiece_size: '2',
                    is_custom: true
                };

                this.addTelescope(telescope);
                this.selectTelescope(telescope);
            },
            removeTelescope: function (telescope, $event) {
                $event.stopImmediatePropagation(); // We have to do this because front-end development is a wasteland
                this.$store.dispatch('removeTelescope', telescope);
                this.$store.dispatch('selectTelescope', this.telescopes[this.telescopes.length - 1]);
            },
            updateFocalLength: function(telescope) {
                telescope.focal_ratio = telescope.focal_length / telescope.aperture;
                this.updateTelescope(telescope);
            },
            updateFocalRatio: function(telescope) {
                telescope.focal_length = telescope.focal_ratio * telescope.aperture;
                this.updateTelescope(telescope);
            },
            ...mapActions([
                'addTelescope',
                'updateTelescope',
                'saveTelescope',
                'selectTelescope'
            ])
        },
        computed: {
            ...mapGetters([
                'selectedTelescope'
            ])
        },
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
                    focal_length: +matches[2],
                    max_eyepiece_size: matches[3]
                };

                this.saveTelescope(telescope);
            }

            this.selectTelescope(telescope);
        }
    };
</script>