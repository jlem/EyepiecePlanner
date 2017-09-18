<template>
    <div class="search-container">
        <input class="field-search" :class="{ 'has-value': value }" type="text" :value="value" @input="emitValue($event.target.value)">
        <i v-if="value == '' || value == null" class="search-icon search-icon-search glyphicon glyphicon-search"></i>
        <i v-if="value != '' && value != null" class="search-icon search-icon-remove glyphicon glyphicon-remove" @click="emitValue('')"></i>
    </div>
</template>
<style lang="sass">
    @import "../../sass/_variables.scss";

    .search-container {
        position: relative;
    }
    .search-icon {
        position: absolute;
        right: 6px;
        top: 10px;
    }

    .search-icon-search {
        opacity: 0.5;
    }

    .search-icon-search {
        cursor: pointer;
        opacity: 0.75;
    }

    .search-icon-remove:hover {
        opacity: 1;
    }

    .field-search {
        width: 100%;
        font-weight: normal;
        background: transparent;
        padding: 5px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .has-value,
    .field-search:focus {
        color: $primary;
        outline: none;
        border-color: $primary;
    }

    .has-value + .glyphicon,
    .field-search:focus + .glyphicon {
        color: $primary;
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