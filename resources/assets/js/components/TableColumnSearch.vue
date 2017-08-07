<template>
    <div class="search-container">
        <input class="field-search" type="text" :value="value" @input="emitValue($event.target.value)">
        <i v-if="value == ''" class="glyphicon glyphicon-search"></i>
        <i v-if="value != ''" class="glyphicon glyphicon-remove" @click="emitValue('')"></i>
    </div>
</template>
<style>
    .search-container {
        position: relative;
    }
    .glyphicon-search,
    .glyphicon-remove {
        position: absolute;
        right: 4px;
        top: 6px;
    }
    .glyphicon-search {
        opacity: 0.5;
    }

    .glyphicon-remove {
        cursor: pointer;
        opacity: 0.75;
    }

    .glyphicon-remove:hover {
        opacity: 1;
    }

    .field-search {
        width: 100%;
        font-weight: normal;
    }
</style>
<script type="text/ecmascript-6">
    'use strict'
    export default {
        props: ['value'],
        methods: {
            emitValue: function (value) {
                this.$emit('input', value);
            }
        }
    }
</script>