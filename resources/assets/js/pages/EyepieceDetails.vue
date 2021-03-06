<template>
    <div>
        <h1>
            {{ eyepiece.focal_length }}mm {{ eyepiece.manufacturer_name }} {{ eyepiece.product_name }}
            <span class="badge back-button-badge" @click="navigateBackToEyepieceList()">
                <i class="glyphicon glyphicon-menu-left"></i> Back to eyepiece list
            </span>
        </h1>
        <ul class="tab-list">
            <li class="tab active-tab">Eyepiece Information</li>
            <li v-if="auth.isAdmin" class="tab-right">
                <a class="tab tab-button" :href="eyepieceLink">Edit</a>
            </li>
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

    .badge {
        position: relative;
        top: -5px;
        font-size: 13px;
        margin-left: 15px;
        padding: 5px 8px;
        color: #fff;
        border-radius: 3px;
    }

    .back-button-badge {
        cursor: pointer;
        background: linear-gradient(rgba(200, 165, 220, 0.15), rgba(200, 165, 220, 0.06));

        i {
            vertical-align: baseline;
            font-weight: bold;
            color: #aa6dca;
        }

        &:hover {
            background: linear-gradient(rgba(200, 165, 220, 0.2), rgba(200, 165, 220, 0.1));
        }
    }
</style>
<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters } from 'vuex';

    export default {
        props: ['id'],
        methods: {
            navigateBackToEyepieceList: function () {
                this.$router.push({ path: `/` });
            }
        },
        computed: {
            eyepieceLink () {
                return `/eyepiece/${this.id}/edit`;
            },
            eyepiece () {
                return window.eyepieces.find(eyepiece => eyepiece.id === +this.id);
            },
            eyepieceInfo () {
                let cards = [
                    { label: 'Focal Length', value: this.eyepiece.focal_length + 'mm' },
                    { label: 'Apparent Field of View', value: this.eyepiece.apparent_field + '°' },
                    { label: 'Eye Relief', value: this.eyepiece.eye_relief + 'mm' },
                    { label: 'Field Stop', value: this.eyepiece.field_stop ? this.eyepiece.field_stop + 'mm' : 'N/A' },
                    { label: 'Barrel Size', value: this.eyepiece.barrel_size + '"' }
                ];

                if (this.eyepiece.is_discontinued) {
                    cards.push({ label: 'Discontinued', type: 'badge', badgeClass: 'badge-alert' });
                }

                return cards;
            },
            ...mapGetters([
                'telescopes',
                'auth'
            ])
        }
    }
</script>