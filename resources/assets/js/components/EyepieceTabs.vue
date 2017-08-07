<template>
    <div class="table-tabs">
        <ul>
            <li v-if="!tab.hiddenFn($store.state)"
                v-bind:class="{ active: isActiveTab(tab) }"
                v-on:click="selectTab(tab)"
                v-for="tab in tabs">
                    {{ tab.tab }} <span v-if="tab.showCount">({{ selectionList.length }})</span>
            </li>
        </ul>
        <share
            :telescope="selectedTelescope"
            :selectedEyepieceIDs="selectionList"></share>
    </div>
</template>
<style>
    .table-tabs {
        border-bottom: 3px solid #3d4044;
        height: 35px;
    }

    .table-tabs ul {
        float: left;
        list-style-type: none;
        padding: 0;
        margin: 0;
        height: 30px;
    }

    .table-tabs ul li {
        border-radius: 3px 3px 0 0;
        padding: 5px 10px;
        border: 1px solid #e2e2e2;
        border-bottom: none;
        margin-right: 5px;
        float: left;
        cursor: pointer;
    }

    .table-tabs ul li.active {
        border: none;
        padding-bottom: 8px;
        background: #3d4044;
        color: #fff;
        cursor: default;
    }
</style>
<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters, mapActions } from 'vuex';

    export default {
        props: ['selectedTelescope', 'tabs', 'selectedTab', 'selectionList'],
        methods: {
            ...mapActions([
                'selectTab',
                'setSelectedEyepieces'
            ]),
            isActiveTab: function (tab) {
                return tab.tab === this.selectedTab.tab;
            }
        },
        watch: {
            selectionList: function (value) {
                if (!value.length) {
                    this.selectTab(this.tabs[0]);
                }
            }
        }
    }
</script>