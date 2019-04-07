<template>
    <div>
        <telescope-form @onTelescopeSaved="filterEyepiecesByFocuserSize($event)"></telescope-form>
        <telescope-tab-list :telescopes="telescopes" :selectedTelescope="selectedTelescope" @onTelescopeSelected="filterEyepiecesByFocuserSize($event)"></telescope-tab-list>
        <div class="list-container">
            <eyepiece-tabs
                :selectedTelescope="selectedTelescope"
                :selections="getSelections('eyepieces')"
                :tabs="listConfig"
                :selected-tab="selectedTab"
                @tab-selected="applyTabConfigToTable">
            </eyepiece-tabs>
            <epp-table
                :config="config"
                :data="computedEyepieces"
                :selections="getSelections('eyepieces')">
            </epp-table>
            <share
                :telescope="selectedTelescope"
                :telescopes="telescopes"
                :selectedEyepieces="computeEyepieces(getSelections('eyepieces'), selectedTelescope)"></share>
        </div>
    </div>
</template>

<style></style>

<script type="text/ecmascript-6">
    'use strict';

    import utils from "../utils";
    import telescopeUtils from "../telescope-utils";
    import { numericRange, contains } from '../search-filters';
    import { mapGetters, mapActions } from 'vuex';
    import formatters from '../formatters';
    import shareService from '../services/share-service';

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
                            filterSelections: false,
                            highlightSelections: true
                        }
                    },
                    {
                        tab: 'Compare',
                        showCount: true,
                        hiddenFn: state => state.selections.eyepieces.length === 0,
                        selection: {
                            filterSelections: true,
                            highlightSelections: false
                        }
                    }
                ],
                config: {
                    defaultSortKey: 'name',
                    onRowClick: (row, $event) => {
                        $event.stopImmediatePropagation();
                        this.$router.push({ path: `eyepiece/${row.id}`, query: null });
                    },
                    selection: {
                        enabled: true,
                        highlightSelections: true,
                        filterSelections: false,
                        isSelectedFn: item => this.getSelections('eyepieces').findIndex(selection => selection.id === item.id) > -1,
                        onSelect: (item, $event) => {
                            $event.stopImmediatePropagation();
                            this.toggleSelection({ group: 'eyepieces', lookupKey: 'id', item });
                        },
                        onClearSelections: this.clearSelections.bind(this, 'eyepieces')
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
                            width: '10%',
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
                            width: '10%',
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
                            width: '10%',
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
                            width: '10%',
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
                            width: '10%',
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
                            width: '10%',
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
                            width: '10%',
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
                            label: 'Size',
                            tooltip: 'Barrel Size',
                            dataKey: 'barrel_size',
                            width: '6%',
                            filterOptions: {
                                type: 'auto-multi-select',
                                config: {
                                    tooltip: 'Automatically filter eyepieces that will fit the focuser of the selected telescope.',
                                    onAutoToggle: $event => {
                                        if ($event.isAutoSelected) {
                                            this.filterEyepiecesByFocuserSize(this.selectedTelescope);
                                        }
                                    },
                                    options: [
                                        { label: 'Auto', value: 'auto', isSelected: true },
                                        { label: '1.25"', value: '1.25', isSelected: false },
                                        { label: 'Dual Barrel', value: '1.25 & 2', isSelected: false },
                                        { label: '2"', value: '2', isSelected: false },
                                        { label: '3"', value: '3', isSelected: false }
                                    ],
                                    filterFn: (selectedFilterValues, dataKey, dataValue) => selectedFilterValues == null || selectedFilterValues.length == 0 || selectedFilterValues.includes(dataValue['barrel_size']),
                                    values: null
                                }
                            }
                        },
                        {
                            label: 'Discontinued?',
                            dataKey: 'is_discontinued',
                            width: '6%',
                            renderComponent: 'boolean-cell',
                            renderComponentOptions: {
                                trueValue: {
                                    label: 'Discontinued',
                                    color: 'red',
                                },
                                falseValue: {
                                    label: 'Available',
                                    color: 'white'
                                }
                            },
                            filterOptions: {
                                type: 'boolean-select',
                                config: {
                                    initialSelectedOption: 'false',
                                    filterFn: (selectedFilterValues, dataKey, dataValue) => selectedFilterValues.includes(dataValue[dataKey]),
                                    values: null
                                }
                            }
                        }
                    ]
                }
            }
        },
        created() {
            let config = this.listConfig[0];

            if (shareService.isSharing(window.location.href)) {
                config = this.listConfig[1];
                this.setSelectedEyepieces(this.getSharedEyepieces());
            }

            this.applyTabConfigToTable(config);
            this.selectTab(config);
        },
        computed: {
            computedEyepieces() {
                return telescopeUtils.computeEyepieceProperties(this.eyepieces, this.selectedTelescope);
            },
            ...mapGetters([
                'selectedEyepieceIDs',
                'selectedTelescope',
                'selectedTab',
                'telescopes'
            ])
        },
        methods: {
            computeEyepieces(eyepieces, telescope) {
                return telescopeUtils.computeEyepieceProperties(eyepieces, telescope);
            },
            applyTabConfigToTable(tab) {
                this.config.selection = Object.assign(this.config.selection, tab.selection);
            },
            filterEyepiecesByFocuserSize(telescope) {
                let filterOptions = this.config.columns
                    .find(c => c.dataKey == 'barrel_size')
                    .filterOptions
                    .config;

                // Check if auto is selected
                let isAutoSelected = filterOptions.options.filter(o => o.value == 'auto' && o.isSelected).length > 0;

                // Set selected values (try to automate this based on selection)
                if (isAutoSelected) {
                    filterOptions.values = this.mapFocuserSizeToFilterOptions(telescope.max_eyepiece_size);
                }
            },
            mapFocuserSizeToFilterOptions(focuserSize) {
                let selectedValues = [];
                switch (focuserSize) {
                    case '1.25':
                        selectedValues = selectedValues.concat(['1.25', '1.25 & 2']); break;
                    case '2':
                        selectedValues = selectedValues.concat(['1.25', '2', '1.25 & 2']); break;
                    case '3':
                        selectedValues = selectedValues.concat(['1.25', '2', '1.25 & 2', '3']); break;
                }

                return selectedValues;
            },
            clearSearchFilters() {
                this.config.columns.forEach(column => {
                    column.filterOptions.config.values = null;
                });
            },
            getSharedEyepieces() {
                let ids = shareService.getSharedEyepieceIDs(window.location.href);
                return this.computedEyepieces.filter(e => ids.includes(e.id));
            },
            getSelections(group) {
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