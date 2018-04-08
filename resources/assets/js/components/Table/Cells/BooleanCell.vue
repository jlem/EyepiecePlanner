<template>
    <div style="text-overflow: ellipsis;" :style="{'color':color}">
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
                        this.props.column.renderComponentOptions.trueValue.label :
                        this.props.column.renderComponentOptions.falseValue.label;
            },
            color: function () {
                return this.props.row[this.props.column.dataKey] ?
                        this.props.column.renderComponentOptions.trueValue.color :
                        this.props.column.renderComponentOptions.falseValue.color;
            }
        }
    }
</script>
