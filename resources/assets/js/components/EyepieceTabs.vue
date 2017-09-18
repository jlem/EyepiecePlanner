<template>
    <div>
        <ul class="tab-list">
            <li v-if="!tab.hiddenFn($store.state)"
                class="tab"
                :class="{ 'active-tab': isActiveTab(tab) }"
                @click="selectTab(tab)"
                v-for="tab in tabs">
                    {{ tab.tab }} <span v-if="tab.showCount">({{ selections.length }})</span>
            </li>
        </ul>
    </div>
</template>
<style lang="sass">
    @import "../../sass/_variables.scss";
</style>
<script type="text/ecmascript-6">
    'use strict';

    import { mapGetters, mapActions } from 'vuex';

    export default {
        props: ['selectedTelescope', 'tabs', 'selectedTab', 'selections'],
        methods: {
            ...mapActions([
                'setSelectedEyepieces'
            ]),
            selectTab: function (tab) {
                this.$store.dispatch('selectTab', tab);
                this.$emit('tab-selected', tab);
            },
            isActiveTab: function (tab) {
                return tab.tab === this.selectedTab.tab;
            }
        },
        watch: {
            selections: function (value) {
                if (!value.length) {
                    this.selectTab(this.tabs[0]);
                }
            }
        }
    }
</script>