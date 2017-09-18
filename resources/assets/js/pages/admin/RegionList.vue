<template>
    <div class="panel">
        <h1>Regions</h1>
        <epp-table :config="config" :data="regions"></epp-table>
    </div>
</template>
<style lang="sass">

</style>
<script type="text/ecmascript-6">
    'use strict';

    import { numericRange, contains } from '../../search-filters';

    export default {
        data: function () {
            return {
                regions: [],
                config: {
                    defaultSortKey: 'id',
                    columns: [
                        {
                            label: 'ID',
                            tooltip: null,
                            dataKey: 'id',
                            width: '5%',
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: ''
                                },
                            }
                        },
                        {
                            label: 'Name',
                            tooltip: null,
                            dataKey: 'name',
                            width: '95%',
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: contains,
                                    values: ''
                                },
                            }
                        }
                    ]
                }
            }
        },
        created: function () {
            this.$http.get('/api/region').then(response => {
                this.regions = response.body.data;
            });
        }
    }
</script>