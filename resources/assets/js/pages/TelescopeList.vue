<template>
    <div>
        <h1>My Telescopes</h1>
        <telescopes-table :telescopes="telescopes"></telescopes-table>
    </div>
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
