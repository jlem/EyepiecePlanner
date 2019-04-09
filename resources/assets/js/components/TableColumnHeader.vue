<template>
    <div>
        <label class="table-tooltip-container field-label" v-on:click="emitSort(sortKey)">
            <span v-if="!!tooltip" class="table-tooltip">{{ tooltip }}</span>
            <slot></slot>
            <i v-if="sortKey == sortCriteria.key && sortCriteria.ascending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
            <i v-if="sortKey == sortCriteria.key && !sortCriteria.ascending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
        </label>
    </div>
</template>
<style lang="sass">
    @import "../../sass/_variables.scss";

    .sort {
        position: relative;
        top: 3px;
        left: 3px;
    }

    .sort-active {
        color: $primary;
        font-size: 12px;
    }

    .field-label {
        display: block;
        cursor: pointer;
        position: relative;
    }
</style>
<script type="text/ecmascript-6">
    'use strict'
    export default {
        props: ['label', 'tooltip', 'sortCriteria', 'sortKey'],
        methods: {
            emitSort: function (sortKey) {
                this.$emit('onSort', sortKey);
            }
        }
    }
</script>