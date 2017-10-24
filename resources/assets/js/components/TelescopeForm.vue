<template>
    <div class="telescope-form-overlay" v-if="isCreateEditMode">
        <div class="modal-container">
            <div class="telescope-form-modal">
                <div class="telescope-form">
                    <div class="telescope-form-field">
                        <label>Telescope Name</label>
                        <input type="text" role="search" v-model="telescopeModel.name" required autocomplete="off"/>
                    </div>
                    <div class="telescope-form-field">
                        <label>Aperture(mm)</label>
                        <input type="text" role="search" v-model="telescopeModel.aperture" @input="updateAperture(telescopeModel)" required autocomplete="off"/>
                    </div>
                    <div class="telescope-form-field">
                        <label>Focal Ratio</label>
                        <input type="text" role="search" v-model="telescopeModel.focal_ratio" @input="updateFocalLength(telescopeModel)" required autocomplete="off" />
                    </div>
                    <div class="telescope-form-field">
                        <label>Focal Length(mm)</label>
                        <input type="text" role="search" v-model="telescopeModel.focal_length" @input="updateFocalRatio(telescopeModel)" required autocomplete="off" />
                    </div>
                    <div class="telescope-form-field" v-bind:class="{selected: telescopeModel.max_eyepiece_size !== ''}">
                        <label>Focuser Size</label>
                        <select v-model="telescopeModel.max_eyepiece_size">
                            <option value="1.25">1.25"</option>
                            <option value="2">2"</option>
                            <option value="3">3"</option>
                        </select>
                    </div>
                </div>
                <div class="close-button" @click="closeModal()">
                    <i class="glyphicon glyphicon-remove"></i> Cancel <span class="escape-hint">(esc)</span>
                </div>
            </div>
            <button class="action-button" v-on:click="save(telescopeModel)"><i class="save-icon glyphicon glyphicon-ok"></i> Save Telescope</button>
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
        overflow-y: auto;
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
        padding-top: 50px;
        width: 200px;
        margin: 0 auto;
    }

    .telescope-form-field {
        margin-bottom: 5px;
        padding: 5px 10px;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    .telescope-form-field label {
        color: $primary;
        font-size: 12px;
        font-weight: normal;
        margin-bottom: 0;
    }

    .telescope-form-field input,
    .telescope-form-field select {
        height: 30px;
        font-size: 18px;
        border: none;
        width: 100%;
        background: none;
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
    import telescopeHttpService from '../services/telescope-http-service';
    import telescopeFactoryService from '../services/telescope-factory-service';
    import telescopeStoreService from '../services/telescope-store-service';
    import authService from '../services/auth-service';

    export default {
        data: function () {
            return {
                telescopeModel: null
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
                    this.closeModal();
                }
            },
            startCreateMode: function ($event) {
                $event.stopImmediatePropagation(); // We have to do this because front-end development is a wasteland
            },
            save: function (telescope) {
                if (this.telescopeToEdit && this.telescopeToEdit.name) {
                    telescopeStoreService.updateTelescope(telescope);
                } else {
                    telescopeStoreService.addTelescope(telescope);
                }
                this.$emit('onTelescopeSaved', telescope);
                this.closeModal();
            },
            updateAperture: function(telescope) {
                this.updateFocalLength(telescope);
            },
            updateFocalRatio: function(telescope) {
                telescope.focal_ratio = telescope.focal_length / telescope.aperture;
            },
            updateFocalLength: function(telescope) {
                telescope.focal_length = telescope.focal_ratio * telescope.aperture;
            },
            closeModal: function () {
                this.closeEditModal();
            },
            ...mapActions([
                'selectTelescope',
                'setTelescopeToEdit',
                'closeEditModal'
            ])
        },
        computed: {
            ...mapGetters([
                'auth',
                'isCreateEditMode',
                'selectedTelescope',
                'telescopeToEdit'
            ])
        },
        watch: {
            isCreateEditMode: function (isOpening) {
                if (!isOpening) {
                    // If we're closing the modal, reset the telescope model to null
                    this.telescopeModel = null;
                } else if(this.telescopeToEdit && this.telescopeToEdit.name) {
                    // If we're editing a telescope, set the model to a new instance of the telescope we're editing
                    this.telescopeModel = Object.assign({}, this.telescopeToEdit);
                } else {
                    // If we're adding a telescope, set the model instance to a new pristine telescope
                    this.telescopeModel = telescopeFactoryService.pristineTelescope();
                }
            }
        }
    };
</script>