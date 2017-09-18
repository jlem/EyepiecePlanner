<template>
    <telescopes-table :telescopes="telescopes"></telescopes-table>
</template>
<style lang="sass"></style>
<script type="text/ecmascript-6">
    'use strict';
    import { mapGetters } from 'vuex';

    export default {
        computed: {
            ...mapGetters([
                'telescopes'
            ])
        }
    };
</script>
