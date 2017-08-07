<template>
    <div>
        <table v-cloak class="eyepiece-table">
            <thead>
                <tr>
                    <th v-if="config.allowSelection" width="30px" v-bind:class="[ {'deselect-all': selectedEyepieceIDs.length > 0}, 'select']" v-on:click="clearSelected()"><i class="glyphicon glyphicon-remove-circle"></i></th>
                    <th width="19%">
                        <table-column-header sort-key="name" :sort-criteria="sort" v-on:sort="sortBy">Name</table-column-header>
                        <table-column-search v-model="filters.name"></table-column-search>
                    </th>
                    <th width="9%">
                        <table-column-header sort-key="focal_length" :sort-criteria="sort" v-on:sort="sortBy">Focal Length</table-column-header>
                        <table-column-search v-model="filters.focal_length"></table-column-search>
                    </th>
                    <th width="9%" v-if="telescope">
                        <table-column-header sort-key="magnification" :sort-criteria="sort" v-on:sort="sortBy">Magnification</table-column-header>
                        <table-column-search v-model="filters.magnification"></table-column-search>
                    </th>
                    <th width="9%" v-if="telescope">
                        <table-column-header sort-key="exit_pupil" :sort-criteria="sort" v-on:sort="sortBy">Exit Pupil</table-column-header>
                        <table-column-search v-model="filters.exit_pupil"></table-column-search>
                    </th>
                    <th width="9%" v-if="telescope">
                        <table-column-header sort-key="tfov" :sort-criteria="sort" v-on:sort="sortBy">True FOV</table-column-header>
                        <table-column-search v-model="filters.tfov"></table-column-search>
                    </th>
                    <th width="9%">
                        <table-column-header sort-key="apparent_field" :sort-criteria="sort" v-on:sort="sortBy">Apparent FOV</table-column-header>
                        <table-column-search v-model="filters.apparent_field"></table-column-search>
                    </th>
                    <th width="9%">
                        <table-column-header sort-key="eye_relief" :sort-criteria="sort" v-on:sort="sortBy">Eye Relief</table-column-header>
                        <table-column-search v-model="filters.eye_relief"></table-column-search>
                    </th>
                    <th width="9%">
                        <table-column-header sort-key="field_stop" :sort-criteria="sort" v-on:sort="sortBy">Field Stop</table-column-header>
                        <table-column-search v-model="filters.field_stop"></table-column-search>
                    </th>
                    <th width="6%">
                        <table-column-header sort-key="price" :sort-criteria="sort" v-on:sort="sortBy">Price</table-column-header>
                        <table-column-search v-model="filters.price"></table-column-search>
                    </th>
                    <th width="6%">
                        <table-column-header sort-key="region" :sort-criteria="sort" v-on:sort="sortBy">Region</table-column-header>
                        <table-column-search v-model="filters.region"></table-column-search>
                    </th>
                    <th width="6%">Barrel Size</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="eyepiece in sortedEyepieces" v-bind:class="{ selected: isSelected(eyepiece) && config.highlightSelections }">
                    <td v-if="config.allowSelection" class="select" v-on:click="selectEyepiece(eyepiece)">
                        <i class="glyphicon glyphicon-ok-circle"></i>
                    </td>
                    <td>{{ eyepiece.name }}</td>
                    <td>{{ eyepiece.focal_length | mm }}</td>
                    <td v-if="telescope">
                        {{ eyepiece.magnification | numberFormat(2) | mag }}
                    </td>
                    <td v-if="telescope">
                        {{ eyepiece.exit_pupil | numberFormat(2) | mm }}
                    </td>
                    <td v-if="telescope">
                        {{ eyepiece.tfov | numberFormat(2) | deg }}
                    </td>
                    <td>{{ eyepiece.apparent_field | deg }}</td>
                    <td>{{ eyepiece.eye_relief | mm }}</td>
                    <td>{{ eyepiece.field_stop | mm }}</td>
                    <td>{{ eyepiece.price | price }}</td>
                    <td>{{ eyepiece.region }}</td>
                    <td>{{ eyepiece.barrel_size }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style>
    .share {
        float: left;
        margin-left: 20px;
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
        width: 350px;
        color: #676c73;
        padding: 3px 8px;
        background: #f4f4f4;
        border: 1px solid #e2e2e2;
        border-left: none;
        border-radius: 0 3px 3px 0;
    }

    .select i {
        opacity: 0.2;
    }

    .deselect-all i {
        opacity: 1;
        color: orangered;
    }


    table.eyepiece-table {
        width: 100%;
        border-spacing: 0;
        border-collapse: collapse;
    }

    .eyepiece-table th,
    .eyepiece-table td {
        padding: 6px 10px;
        border: 1px solid #e2e2e2;
    }

    .eyepiece-table th {
        background-color: #fff;
        position: relative;
    }

    tr:hover {
        background-color: #fafafa;
    }

    tr:nth-child(odd) {
        background-color: #f4f4f4;
    }

    tr:nth-child(odd):hover {
        background-color: #efefef;
    }

    tr.selected {
        background-color: #e9ffe9;
    }

    tr.selected:nth-child(odd) {
        background-color: #dbf1db;
    }

    tr .select {
        cursor: pointer;
    }

    tr.selected .select i {
        opacity: 1;
        color: darkseagreen;
    }
</style>

<script type="text/ecmascript-6">
    'use strict';

    import formatters from '../formatters';
    import utils from '../utils';
    import telescopeUtils from '../telescope-utils';
    import { debounce } from 'lodash';
//    import store from '../store';
    import { mapGetters } from 'vuex';

    const sortBy = function (sortKey) {
        this.sort.ascending = (this.sort.key == sortKey) ? !this.sort.ascending : true;
        this.sort.key = sortKey;
    };

    const filterSelection = (filterList, config, eyepiece) => {
        if (!filterList.length || !config.filterBySelection) {
            return true; // don't filter anything
        } else {
            return filterList.includes(eyepiece.id);
        }
    }

    const updateEyepieces = function () {
        return this.eyepieces
                .filter(filterSelection.bind(null, this.selectedEyepieceIDs, this.config))
                .filter(telescopeUtils.eyepieceFitsTelescope.bind(null, this.telescope))
                .filter(telescopeUtils.contains.bind(null, this.filters.name, 'name'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.focal_length), 'focal_length'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.magnification), 'magnification'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.exit_pupil), 'exit_pupil'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.tfov), 'tfov'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.apparent_field), 'apparent_field'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.eye_relief), 'eye_relief'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.field_stop), 'field_stop'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.price), 'price'))
                .filter(telescopeUtils.contains.bind(null, this.filters.region, 'region'))
                .sort(utils.compare.bind(this, this.sort.key, 'focal_length', this.sort.ascending));
    };

    let refreshDataFilters = function () {
        return {
            name: '',
            focal_length: '',
            magnification: '',
            exit_pupil: '',
            tfov: '',
            apparent_field: '',
            eye_relief: '',
            field_stop: '',
            price: '',
            region: ''
        }
    };

    // View Model
    export default {
        props: ['eyepieces', 'selectedEyepieceIDs', 'telescope', 'config'],
        data: () => {
            return {
                sort: {
                    key: 'name',
                    ascending: true
                },
                filters: refreshDataFilters()
            }
        },
        created: function () {
            console.log(this.config);
            this.$store.dispatch('setSelectedEyepieces', this.selectedEyepieceIDs);
        },
        computed: {
            sortedEyepieces: updateEyepieces
        },
        methods: {
            sortBy,
            isSelected: function (eyepiece) {
                return this.selectedEyepieceIDs.includes(eyepiece.id);
            },
            selectEyepiece: function (eyepiece) {
                let action = this.isSelected(eyepiece) ? 'deselectEyepiece' : 'selectEyepiece';
                this.$store.dispatch(action, eyepiece);
            },
            clearSelected: function () {
                this.$store.dispatch('setSelectedEyepieces', []);
            },
            clearFilters: function () {
                this.filters = refreshDataFilters();
            }
        },
        filters: formatters
    };
</script>
