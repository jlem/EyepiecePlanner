<template>
    <div class="info-group" :class="{ 'show-border': showBorder }">
        <div v-for="card in cards" class="info-card">
            <div class="info-card-label">{{ card.label }}</div>
            {{ card.value }}
        </div>
    </div>
</template>
<style lang="sass">
    @import '../../sass/_variables.scss';

    .info-group {
        display: flex;
    }

    .show-border {
        border-top: 3px solid $primary;
    }

    .info-card {
        font-size: 24px;
        flex: 1;
        text-align: center;
        margin-right: 5px;
        color: #fff;
        padding-top: 20px;
        padding-bottom: 20px;
        background: linear-gradient(rgba(200, 165, 220, 0.15), rgba(200, 165, 220, 0.06));

    &:last-of-type {
         margin-right: 0;
     }
    }

    .info-card-label {
        font-size: 18px;
        font-weight: bold;
        color: $primary;
    }
</style>
<script type="text/ecmascript-6">
    'use strict';

    export default {
        props: ['cards', 'show-border'],
    }
</script>