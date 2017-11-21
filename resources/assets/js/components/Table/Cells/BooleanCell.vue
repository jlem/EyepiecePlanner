<template>
    <div style="text-overflow: ellipsis;">
        {{ value }}
    </div>
</template>
<style></style>
<script type="text/ecmascript-6">
    export default {
        props: ['props'],
        computed: {
            value: function () {
                return this.props.row[this.props.column.dataKey] ?
                        this.props.column.renderComponentOptions.trueLabel :
                        this.props.column.renderComponentOptions.falseLabel;
            }
        }
    }
</script>
