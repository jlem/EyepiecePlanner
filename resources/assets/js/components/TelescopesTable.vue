<template>
    <epp-table :config="config" :data="computedTelescopes"></epp-table>
</template>
<style lang="sass">

</style>
<script type="text/ecmascript-6">
    import telescopeUtils from "../telescope-utils";
    import { numericRange, contains } from '../search-filters';
    import formatters from '../formatters';

    'use strict';

    export default {
        props: ['telescopes', 'eyepiece'],
        data: function () {
            return {
                config: {
                    defaultSortKey: 'name',
                    onRowClick: function (row, $event) {
                        $event.stopImmediatePropagation();
                        this.$router.push({ path: `/telescopes/${row.id}` });
                    }.bind(this),
                    columns: this.getColumns()
                }
            }
        },
        methods: {
            getColumns() {
                let columns = [
                    {
                        label: 'Name',
                        tooltip: null,
                        dataKey: 'name',
                        width: '10%',
                        filterOptions: {
                            type: 'search',
                            config: {
                                filterFn: contains,
                                values: ''
                            },
                        }
                    }
                ];

                let telescopeColumns = [
                    {
                        label: 'Aperture',
                        tooltip: null,
                        dataKey: 'aperture',
                        width: '10%',
                        formatFn: formatters.mm,
                        filterOptions: {
                            type: 'search',
                            config: {
                                filterFn: numericRange,
                                values: ''
                            },
                        }
                    },
                    {
                        label: 'Focal Length',
                        tooltip: null,
                        dataKey: 'focal_length',
                        width: '10%',
                        formatFn: formatters.mm,
                        filterOptions: {
                            type: 'search',
                            config: {
                                filterFn: numericRange,
                                values: ''
                            },
                        }
                    },
                    {
                        label: 'Focal Ratio',
                        tooltip: null,
                        dataKey: 'focal_ratio',
                        width: '10%',
                        filterOptions: {
                            type: 'search',
                            config: {
                                filterFn: numericRange,
                                values: ''
                            },
                        }
                    },
                ];

                if (this.eyepiece) {
                    let eyepieceCalculationColumns = [
                        {
                            label: 'Magnification',
                            tooltip: null,
                            dataKey: 'magnification',
                            width: '10%',
                            formatFn: formatters.mag,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: ''
                                },
                            }
                        },
                        {
                            label: 'Exit Pupil',
                            tooltip: null,
                            dataKey: 'exit_pupil',
                            width: '10%',
                            formatFn: formatters.mm,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: ''
                                },
                            }
                        },
                        {
                            label: 'True FOV',
                            tooltip: null,
                            dataKey: 'tfov',
                            width: '10%',
                            formatFn: formatters.deg,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: ''
                                },
                            }
                        }
                    ];

                    columns = columns.concat(eyepieceCalculationColumns);
                }

                columns = columns.concat(telescopeColumns);

                return columns;
            }
        },
        computed: {
            computedTelescopes() {
                if (!this.eyepiece) {
                    return this.telescopes;
                }

                let computedTelescopes = this.telescopes.map(telescope => {
                    telescope.effective_focal_length = telescope.focal_length;

                    let calculations = {
                        magnification: telescopeUtils.calculateMagnification(this.eyepiece, telescope),
                        exit_pupil: telescopeUtils.calculateExitPupil(this.eyepiece, telescope),
                        tfov: telescopeUtils.calculateTrueFoV(this.eyepiece, telescope)
                    };

                    return Object.assign({}, telescope, calculations);
                });

                return computedTelescopes;
            }
        }
    }
</script>
