<template>
    <div>
        <telescope-form @onTelescopeSaved="filterEyepieceSize($event)"></telescope-form>
        <telescope-list :telescopes="telescopes" :selectedTelescope="selectedTelescope" @onTelescopeSelected="filterEyepieceSize($event)"></telescope-list>
        <div class="list-container">
            <eyepiece-tabs
                    :selectedTelescope="selectedTelescope"
                    :selections="getSelections('eyepieces')"
                    :tabs="listConfig"
                    :selected-tab="selectedTab"
                    @tab-selected="updateConfig">
            </eyepiece-tabs>
            <epp-table
                    :config="config"
                    :data="computedEyepieces"
                    :selections="getSelections('eyepieces')">
            </epp-table>
            <!--<share-->
                    <!--:telescope="selectedTelescope"-->
                    <!--:selectedEyepieces="getSelections('eyepieces')"></share>-->
        </div>
    </div>
</template>

<style></style>

<script type="text/ecmascript-6">
    'use strict';

    import telescopeUtils from "../telescope-utils";
    import { numericRange, contains } from '../search-filters';
    import { mapGetters, mapActions } from 'vuex';
    import formatters from '../formatters';

    const EYEPIECE_REGEX = /ep=(.*)/;

    // View Model
    export default {
        data: function () {
            return {
                eyepieces: window.eyepieces,
                listConfig: [
                    {
                        tab: 'All Eyepieces',
                        showCount: false,
                        hiddenFn: () => false,
                        selection: {
                            enabled: true,
                            filterSelections: false,
                            highlightSelections: true
                        }
                    },
                    {
                        tab: 'Compare',
                        showCount: true,
                        hiddenFn: (state) => state.selections.eyepieces.length === 0,
                        selection: {
                            enabled: true,
                            filterSelections: true,
                            highlightSelections: false
                        }
                    }
                ],
                config: {
                    defaultSortKey: 'name',
                    onRowClick: function (row, $event) {
                        $event.stopImmediatePropagation();
                        this.$router.push({ path: `eyepiece/${row.id}` });
                    }.bind(this),
                    selection: {
                        enabled: true,
                        highlightSelections: true,
                        filterSelections: false,
                        isSelectedFn: function (item) {
                            return this.getSelections('eyepieces').findIndex(selection => selection.id === item.id) > -1;
                        }.bind(this),
                        onSelect: function (item, $event) {
                            $event.stopImmediatePropagation();
                            this.toggleSelection({ group: 'eyepieces', lookupKey: 'id', item });
                        }.bind(this),
                        onClearSelections: function () {
                            this.clearSelections('eyepieces');
                        }.bind(this)
                    },
                    columns: [
                        {
                            label: 'Name',
                            tooltip: null,
                            dataKey: 'name',
                            width: '16%',
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: contains,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'FL',
                            tooltip: 'Focal Length',
                            dataKey: 'focal_length',
                            width: '9%',
                            formatFn: formatters.mm,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'Mag',
                            tooltip: 'Magnification',
                            dataKey: 'magnification',
                            width: '9%',
                            formatFn: formatters.mag,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'EP',
                            tooltip: 'Exit Pupil',
                            dataKey: 'exit_pupil',
                            width: '9%',
                            formatFn: formatters.mm,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'TFOV',
                            tooltip: 'True Field of View',
                            dataKey: 'tfov',
                            width: '9%',
                            formatFn: formatters.deg,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'AFOV',
                            tooltip: 'Apparent Field of View',
                            dataKey: 'apparent_field',
                            width: '9%',
                            formatFn: formatters.deg,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'ER',
                            tooltip: 'Eye Relief (mm)',
                            dataKey: 'eye_relief',
                            width: '9%',
                            formatFn: formatters.mm,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'FS',
                            tooltip: 'Field Stop Diameter (mm)',
                            dataKey: 'field_stop',
                            width: '9%',
                            formatFn: formatters.mm,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'Cost',
                            tooltip: null,
                            dataKey: 'price',
                            width: '9%',
                            formatFn: formatters.price,
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: numericRange,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'Loc',
                            tooltip: 'Location',
                            dataKey: 'region',
                            width: '6%',
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: contains,
                                    values: null
                                },
                            }
                        },
                        {
                            label: 'Size',
                            tooltip: 'Barrel Size',
                            dataKey: 'barrel_size',
                            width: '6%',
                            filterOptions: {
                                type: 'search',
                                config: {
                                    filterFn: (telescopeMaxEyepieceSize, dataKey, dataValue) => {
                                        let eyepieceSize = dataValue['barrel_size'];

                                        if (telescopeMaxEyepieceSize == null || telescopeMaxEyepieceSize == '') {
                                            return true; // Don't filter if search is empty
                                        }

                                        if (telescopeMaxEyepieceSize == '1.25' && eyepieceSize.includes('1.25')) {
                                            return true; // Accepts eyepieces designated 1.25" or 1.25" & 2"
                                        }

                                        if (telescopeMaxEyepieceSize == '2' && eyepieceSize != '3') {
                                            return true; // Accepts all but 3" eyepieces
                                        }

                                        if (telescopeMaxEyepieceSize == '3') {
                                            return true; // Accepts all eyepieces
                                        }

                                        return false;
                                    },
                                    values: null
                                }
                            }
                        }
                    ]
                }
            }
        },
        created: function () {
            if (this.isSharing()) {
                this.setSelectedEyepieces(this.getSharedEyepieces());
                this.selectTab(this.listConfig[1]); // tab[1] is comparison tab - need to find a more elegant solution to this
            } else {
                this.selectTab(this.listConfig[0]); // tab[0] is the all eyepieces tab - need to find a more elegant solution to this
            }
        },
        computed: {
            computedEyepieces: function () {
                return telescopeUtils.computeEyepieceProperties(this.eyepieces, this.selectedTelescope, this.magnificationModifiers);
            },
            ...mapGetters([
                'magnificationModifiers',
                'selectedEyepieceIDs',
                'selectedTelescope',
                'selectedTab',
                'telescopes'
            ])
        },
        methods: {
            updateConfig: function (tab) {
                this.applyTabConfiguration(tab);
                this.clearSearchFilters();
            },
            applyTabConfiguration: function (tab) {
                this.config.selection = Object.assign(this.config.selection, tab.selection);
            },
            filterEyepieceSize: function (telescope) {
                this.config.columns
                    .find(c => c.dataKey == 'barrel_size')
                    .filterOptions
                    .config
                    .values = telescope.max_eyepiece_size
            },
            clearSearchFilters: function () {
                this.config.columns.forEach(column => {
                    column.filterOptions.config.values = null;
                });
            },
            getSharedEyepieces: function () {
                let matches = window.location.hash.match(EYEPIECE_REGEX);
                return matches[1].split(',').map(id => +id);
            },
            isSharing: function () {
                return EYEPIECE_REGEX.test(window.location.hash);
            },
            getSelections: function (group) {
                return this.$store.getters.getSelections(group);
            },
            ...mapActions([
                'toggleSelection',
                'selectTab',
                'selectEyepiece',
                'setSelectedEyepieces',
                'clearSelections'
            ])
        }
    };
</script>