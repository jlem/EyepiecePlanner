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
                        width: '22%',
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
                        width: '13%',
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
                        width: '13%',
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
                        width: '13%',
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
                            width: '13%',
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
                            width: '13%',
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
                            width: '13%',
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

                return columns.concat(telescopeColumns);
            }
        },
        computed: {
            computedTelescopes() {
                if (!this.eyepiece) {
                    return this.telescopes;
                }

                let computedTelescopes = this.telescopes.map(telescope => {
                    let calculations = {
                        magnification: formatters.numberFormat(telescopeUtils.calculateMagnification(this.eyepiece, telescope)),
                        exit_pupil: formatters.numberFormat(telescopeUtils.calculateExitPupil(this.eyepiece, telescope)),
                        tfov: formatters.numberFormat(telescopeUtils.calculateTrueFoV(this.eyepiece, telescope))
                    };

                    return Object.assign({}, telescope, calculations);
                });

                return computedTelescopes;
            }
        }
    }
</script>
