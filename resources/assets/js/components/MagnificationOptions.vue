<template>
    <div class="mag-options">
        <ul>
            <li v-for="option in magnificationOptions">
                <input :id="option.value" v-model="option.selected" @change="updateMagnificationSelections()" type="checkbox">
                <label :for="option.value" v-if="option.label">{{ option.label }} ({{ option.value }}x)</label>
                <label :for="option.value" v-if="!option.label">{{ option.value }}x</label>
            </li>
        </ul>
    </div>
</template>
<style lang="sass">
    .mag-options {
        ul {
            list-style-type: none;
        }

        label {
            cursor: pointer;
        }
    }
</style>
<script type="text/ecmascript-6">
    'use strict';
    import { mapGetters, mapActions } from 'vuex';

    export default {
        data: function () {
            return {
                magnificationOptions: [
                    { label: 'Coma Corrector', value: 1.15, selected: false },
                    { value: 1.5, selected: false },
                    { value: 1.75, selected: false },
                    { value: 2, selected: false },
                    { value: 2.5, selected: false },
                    { value: 3, selected: false },
                    { value: 4, selected: false },
                    { value: 5, selected: false },
                ]
            }
        },
        methods: {
            updateMagnificationSelections() {
                let selections = this.magnificationOptions
                        .filter(x => x.selected)
                        .reduce((previousValue, currentValue) => {
                            previousValue.push(currentValue.value);
                            return previousValue;
                        }, []);

                this.setMagnificationModifiers(selections);
            },
            ...mapActions([
                'setMagnificationModifiers'
            ])
        }
    }
</script>