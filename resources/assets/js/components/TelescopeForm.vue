<template>
    <div class="container">
        <ul class="telescopes">
            <li v-bind:class="[{ active: telescope.name == selectedTelescope.name }, 'telescope-tab']"
                v-for="(telescope, index) in telescopes"
                v-on:click="selectTelescope(telescope)">
                    {{ telescope.name }}
            </li>
        </ul>
        <div class="telescope-form">
            <div class="telescope-form-field">
                <div class="animated-field">
                    <input type="text" role="search"  v-model="selectedTelescope.aperture" required autocomplete="off"/>
                    <label>Telescope Aperture (mm)</label>
                </div>
            </div>
            <div class="telescope-form-field">
                <div class="animated-field">
                    <input type="text" role="search" v-model="selectedTelescope.focal_length" required autocomplete="off" />
                    <label>Telescope Focal Length (mm)</label>
                </div>
            </div>
            <div class="telescope-form-field">
                <div class="animated-field">
                    <select v-model="selectedTelescope.max_eyepiece_size" required>
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
        border: 1px solid #e2e2e2;
        border-radius: 3px 3px 0 0;
        border-bottom: 0;
        padding: 5px 10px;
        cursor: pointer;
    }

    .telescope-tab.active {
        background: #3d4044;
        border: 1px solid #34373b;
        border-bottom: 3px solid #3d4044;
        color: #fff;
        cursor: default;
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

    export default {
        props: ['changes', 'telescopes'],
        data: function () {
            return {
                selectedTelescope: {}
            }
        },
        methods: {
            selectTelescope: function (telescope) {
                this.selectedTelescope = telescope;
            }
        },
        created: function () {
            this.selectTelescope.call(this, this.telescopes[0]);
        },
        watch: {
            selectedTelescope: {
                handler: function () {
                    this.changes(this.selectedTelescope);
                },
                deep: true
            }
        }
    };
</script>