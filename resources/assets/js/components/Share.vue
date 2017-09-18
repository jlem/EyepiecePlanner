<template>
    <div class="share" v-if="selectedEyepieces.length > 0">
        <label onclick="this.nextSibling.select()"><i class="glyphicon glyphicon-share"></i> Share</label><input onclick="this.select()" readonly type="text" v-bind:value="shareUrl">
    </div>
</template>
<style>
    .share {
        margin-left: 20px;
        text-align: center;
    }
    .share label {
        border: 1px solid #de4100;
        border-radius: 3px 0 0 3px;
        background: orangered;
        color: #fff;
        padding: 3px 8px;
        margin: 0;
    }
    .share input {
        margin: 0;
        width: 450px;
        color: #676c73;
        padding: 3px 8px;
        background: #f4f4f4;
        border: 1px solid #e2e2e2;
        border-left: none;
        border-radius: 0 3px 3px 0;
    }
</style>
<script type="text/ecmascript-6">
    'use strict';

    export default {
        props: ['telescope', 'selectedEyepieces'],
        computed: {
            shareUrl: function () {
                let url = 'https://eyepieceplanner.com';
                let telescope = '/#t=' + this.telescope.aperture + ',' + this.telescope.focal_length + ',' + this.telescope.max_eyepiece_size;
                let eyepieces = ';ep=' + this.selectedEyepieces.reduce((previousValue, currentValue) => {
                    previousValue.push(currentValue.id);
                    return previousValue;
                }, []).join(',');
                return url + telescope + eyepieces;
            }
        }
    }
</script>