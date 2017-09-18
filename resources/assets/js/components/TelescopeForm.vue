<template>
    <div class="telescope-form-overlay" v-if="isCreateEditMode">
        <div class="modal-container">
            <div class="telescope-form-modal">
                <div class="telescope-form">
                    <div class="telescope-form-field name-field">
                        <input placeholder="Telescope Name" type="text" role="search" v-model="newTelescope.name" required autocomplete="off"/>
                    </div>
                    <div class="telescope-form-field aperture-field">
                        <input placeholder="Aperture (mm)" type="text" role="search" v-model="newTelescope.aperture" @input="updateAperture(newTelescope)" required autocomplete="off"/>
                    </div>
                    <div class="telescope-form-field focal-ratio-field">
                        <input placeholder="Focal Ratio" type="text" role="search" v-model="newTelescope.focal_ratio" @input="computeFocalLength(newTelescope)" required autocomplete="off" />
                    </div>
                    <div class="telescope-form-field focal-length-field">
                        <input placeholder="Focal Length(mm)" type="text" role="search" v-model="newTelescope.focal_length" @input="computeFocalRatio(newTelescope)" required autocomplete="off" />
                    </div>
                    <div class="telescope-form-field eyepiece-size-field" v-bind:class="{selected: newTelescope.max_eyepiece_size !== ''}">
                        <select v-model="newTelescope.max_eyepiece_size">
                            <option value="" disabled selected hidden>Max eyepiece size...</option>
                            <option value="1.25">1.25"</option>
                            <option value="2">2"</option>
                            <option value="3">3"</option>
                        </select>
                    </div>
                </div>
                <div class="close-button" @click="closeEditModal()">
                    <i class="glyphicon glyphicon-remove"></i> Cancel <span class="escape-hint">(esc)</span>
                </div>
            </div>
            <button class="action-button" v-on:click="saveTelescope(newTelescope)"><i class="save-icon glyphicon glyphicon-ok"></i> Save Telescope</button>
        </div>
    </div>
</template>

<style lang="sass">
    @import "../../sass/_variables.scss";

    .save-icon {
        margin-right: 10px;
    }

    .telescope-form-overlay {
        z-index: 99999;
        height: 100%;
        width: 100%;
        position: fixed;
        background: rgba(0,0,0,0.5);
        top: 0;
        left: 0;
    }

    .modal-container{
        width: 900px;
        display: block;
        margin: 100px auto 0 auto;
    }

    .telescope-form-modal {
        border-radius: 3px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
        width: 900px;
        height: 563px;
        background-image: linear-gradient(rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.01)), url('/modalbg.jpg');
        position: relative;
    }

    .close-button {
        position: absolute;
        color: #fff;
        border-radius: 0 2px 0 10px;
        top: 0;
        right: 0;
        padding: 8px 15px;
        border-left: 1px solid rgba(0, 0, 0, 0.5);
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        cursor: pointer;
        background: $primary_gradient_transparent;

        &:hover {
             background: $primary_gradient_transparent_hover;
         }
    }

    .escape-hint {
        opacity: 0.33;
    }

    .telescope-form {
        padding-top: 65px;
        width: 300px;
        margin: 0 auto;
    }

    .telescope-form-field {
        margin-left: 60px;
        padding-left: 55px;
        margin-bottom: 32px;
    }

    .name-field {
        background: url('/telescope-form-sprite.png') no-repeat 0 0;
    }

    .aperture-field {
        background: url('/telescope-form-sprite.png') no-repeat 0 -30px;
    }

    .focal-ratio-field {
        background: url('/telescope-form-sprite.png') no-repeat 0 -60px;
    }

    .focal-length-field {
        background: url('/telescope-form-sprite.png') no-repeat 0 -90px;
    }

    .eyepiece-size-field {
        padding-left: 48px;
        background: url('/telescope-form-sprite.png') no-repeat 0 -120px;
    }

    .telescope-form-field input,
    .telescope-form-field select {
        height: 30px;
        font-size: 18px;
        border: none;
        width: 100%;
        background: none;
        border-bottom: 1px solid rgba(180, 112, 187, 0.1);
        outline: none;
        padding: 0;
        color: #fff;
    }

    .telescope-form-field select {
        color: $primary;
    }

    .telescope-form-field.selected select {
        font-weight: normal;
        color: #fff;
    }

    ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: $primary;
    }
    ::-moz-placeholder { /* Firefox 19+ */
        color: $primary;
    }
    :-ms-input-placeholder { /* IE 10+ */
        color: $primary;
    }
    :-moz-placeholder { /* Firefox 18- */
        color: $primary;
    }

    .action-button {
        outline: none;
        width: 100%;
        background: $primary-gradient;
        color: #fff;
        padding: 15px;
        font-size: 18px;
        border-radius: 0 0 3px 3px;
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.25);
        border-bottom: 1px solid rgba(0, 0, 0, 0.5);
        box-shadow: 0 1px 3px rgba(0,0,0,0.5);
        box-sizing: border-box;
        cursor: pointer;

        &:hover {
             background: $primary-gradient-hover;
         }
    }
</style>

<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters, mapActions } from 'vuex';

    export default {
        data: function () {
            return {
                newTelescope: {
                    name: null,
                    aperture: null,
                    focal_ratio: null,
                    focal_length: null,
                    max_eyepiece_size: '',
                    is_custom: true
                },
                defaultTelescope: {
                    name: null,
                    aperture: null,
                    focal_ratio: null,
                    focal_length: null,
                    max_eyepiece_size: '',
                    is_custom: true
                }
            }
        },
        created: function () {
            window.addEventListener('keyup', this.escape.bind(this));
        },
        destroyed: function () {
            window.removeEventListener('keyup', this.escape.bind(this));
        },
        methods: {
            escape: function (event) {
                if(event.keyCode == 27) {
                    this.closeEditModal();
                }
            },
            startCreateMode: function ($event) {
                $event.stopImmediatePropagation(); // We have to do this because front-end development is a wasteland
            },
            saveTelescope: function (telescope) {
                telescope.is_custom = true;
                this.addTelescope(telescope);
                this.selectTelescope(telescope);
                this.newTelescope = Object.assign({}, this.defaultTelescope);
                this.closeEditModal();
            },
            updateAperture: function(telescope) {
                this.computeFocalLength(telescope);
            },
            computeFocalRatio: function(telescope) {
                telescope.focal_ratio = telescope.focal_length / telescope.aperture;
            },
            computeFocalLength: function(telescope) {
                telescope.focal_length = telescope.focal_ratio * telescope.aperture;
            },
            ...mapActions([
                'addTelescope',
                'selectTelescope',
                'closeEditModal'
            ])
        },
        computed: {
            ...mapGetters([
                'isCreateEditMode',
                'selectedTelescope'
            ])
        }
    };
</script>