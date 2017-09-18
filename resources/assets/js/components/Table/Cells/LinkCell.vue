<template>
    <div>
        <router-link :to="link">{{ label }}</router-link>
    </div>
</template>
<style></style>
<script type="text/ecmascript-6">
    export default {
        props: ['props'],
        computed: {
            link: function () {
                return this.props.link;
            },
            label: function () {
                return this.props.label;
            }
        }
    }
</script>