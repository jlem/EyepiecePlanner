<template>
    <div>
        <telescope-form :telescopes="telescopes"></telescope-form>
        <eyepiece-tabs
                :selectedTelescope="selectedTelescope"
                :selection-list="selectedEyepieceIDs"
                :tabs="listConfig"
                :selected-tab="selectedTab">
        </eyepiece-tabs>
        <eyepiece-table
                :eyepieces="computedEyepieces"
                :telescope="selectedTelescope"
                :selectedEyepieceIDs="selectedEyepieceIDs"
                :config="selectedTab">
        </eyepiece-table>
    </div>
</template>

<script type="text/ecmascript-6">
    'use strict';

    import telescopeUtils from "../telescope-utils";
    import { mapGetters, mapActions } from 'vuex';

    const EYEPIECE_REGEX = /ep=(.*)/

    let computeEyepieces = (eyepieces, telescope) => telescopeUtils.computeEyepieceProperties(eyepieces, telescope);

    // View Model
    export default {
        props: ['eyepieces', 'listConfig'],
        created: function () {
            if (this.isSharing()) {
                this.setSelectedEyepieces(this.getSharedEyepieces());
                this.selectTab(this.listConfig[1]); // tab[1] is comparison tab - need to find a more elegant solution to this
            } else {
                this.selectTab(this.listConfig[0]); // tab[0] is the all eyepieces tab - need to find a more elegant solution to this
            }
        },
        computed: {
            computedEyepieces: function () {
                return computeEyepieces(this.eyepieces, this.selectedTelescope)
            },
            ...mapGetters([
                'selectedEyepieceIDs',
                'selectedTelescope',
                'selectedTab',
                'telescopes'
            ])
        },
        methods: {
            getSharedEyepieces: function () {
                let matches = window.location.hash.match(EYEPIECE_REGEX);
                return matches[1].split(',').map(id => +id);
            },
            isSharing: function () {
                return EYEPIECE_REGEX.test(window.location.hash);
            },
            ...mapActions([
                'selectTab',
                'setSelectedEyepieces'
            ])
        }
    };
</script>