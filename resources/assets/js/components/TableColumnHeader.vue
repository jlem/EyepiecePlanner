<template>
    <div>
        <label class="field-label" v-on:click="emitSort(sortKey)">
            <slot></slot>
            <i v-if="sortKey != sortCriteria.key" class="sort glyphicon glyphicon-minus"></i>
            <i v-if="sortKey == sortCriteria.key && sortCriteria.ascending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
            <i v-if="sortKey == sortCriteria.key && !sortCriteria.ascending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
        </label>
    </div>
</template>
<style>
    .sort {
        color: #aec7d8;
    }

    .sort-active {
        color: orangered;
    }

    .field-label {
        display: block;
        cursor: pointer;
    }
</style>
<script type="text/ecmascript-6">
    'use strict'
    export default {
        props: ['label', 'sortCriteria', 'sortKey'],
        methods: {
            emitSort: function (sortKey) {
                this.$emit('sort', sortKey);
            }
        }
    }
</script>