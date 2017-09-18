<template>
    <div>
        <label class="field-label" v-on:click="emitSort(sortKey)">
            <span v-if="!!tooltip" class="field-tooltip">{{ tooltip }}</span>
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
    }

    .sort-active {
        color: $primary;
    }

    .field-tooltip {
        white-space: nowrap;
        position: absolute;
        top: -47px;
        left: -8px;
        background: rgba(0,0,0,0.75);
        color: #fff;
        padding: 4px 8px;
        border-radius: 3px;
        display: none;
        font-weight: normal;
    }

    .field-tooltip:after {
        position: absolute;
        bottom: -4px;
        display: block;
        width: 10px;
        height: 10px;
        content: '▼';
        color: rgba(0,0,0,0.75);
    }

    .field-label {
        display: block;
        cursor: pointer;
        position: relative;
    }

    .field-label:hover .field-tooltip {
        display: block;
    }

</style>
<script type="text/ecmascript-6">
    'use strict'
    export default {
        props: ['label', 'tooltip', 'sortCriteria', 'sortKey'],
        methods: {
            emitSort: function (sortKey) {
                this.$emit('sort', sortKey);
            }
        }
    }
</script>