<template>
    <div v-bind:class="{ computed: isComputed(), 'table-tooltip-container': true }">
        <div class="computed" v-if="isComputed()">
            <span class="table-tooltip">
                <span class="asterisk" v-if="isComputed()">*</span>Estimate based on apparent field of view.
            </span>
            {{ props.row['tfov'] }}°<span class="asterisk" v-if="isComputed()">*</span>
        </div>
        <div v-else>
            {{ props.row['tfov'] }}°
        </div>
    </div>
</template>
<style>
    .computed {
        font-style: italic;
    }

    .asterisk {
        color: red;
    }
</style>
<script type="text/ecmascript-6">
    export default {
        props: ['props'],
        methods: {
            isComputed() {
                return !this.props.row['field_stop'];
            }
        }
    }
</script>

