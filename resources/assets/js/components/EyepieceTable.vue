<template>
    <div>
        <div class="table-tabs">
            <ul>
                <li v-bind:class="{ active: isActiveTab('all') }" v-on:click="showTab('all')">All Eyepieces</li>
                <li v-if="getSelectedCount() > 0" v-bind:class="{ active: isActiveTab('compare') }" v-on:click="showTab('compare')">Compare Selected ({{ getSelectedCount() }})</li>
            </ul>
            <div class="share" v-if="getSelectedCount() > 0 && isActiveTab('compare')" style="text-align: center">
                <label onclick="this.nextSibling.select()"><i class="glyphicon glyphicon-share"></i> Share</label><input onclick="this.select()" readonly type="text" v-bind:value="getShareUrl()">
            </div>
        </div>
        <table v-cloak class="eyepiece-table">
            <thead>
                <tr>
                    <th width="30px" v-bind:class="[ {'deselect-all': getSelectedCount() > 0}, 'select']" v-on:click="clearSelected()"><i class="glyphicon glyphicon-remove-circle"></i></th>
                    <th width="20%">
                        <table-column-header sort-key="name" :sort-criteria="sort" v-on:sort="sortBy">Name</table-column-header>
                        <table-column-search v-model="filters.name"></table-column-search>
                    </th>
                    <th width="10%">
                        <table-column-header sort-key="focal_length" :sort-criteria="sort" v-on:sort="sortBy">Focal Length</table-column-header>
                        <table-column-search v-model="filters.focal_length"></table-column-search>
                    </th>
                    <th width="10%" v-if="telescope">
                        <table-column-header sort-key="magnification" :sort-criteria="sort" v-on:sort="sortBy">Magnification</table-column-header>
                        <table-column-search v-model="filters.magnification"></table-column-search>
                    </th>
                    <th width="10%" v-if="telescope">
                        <table-column-header sort-key="exit_pupil" :sort-criteria="sort" v-on:sort="sortBy">Exit Pupil</table-column-header>
                        <table-column-search v-model="filters.exit_pupil"></table-column-search>
                    </th>
                    <th width="10%" v-if="telescope">
                        <table-column-header sort-key="tfov" :sort-criteria="sort" v-on:sort="sortBy">True FOV</table-column-header>
                        <table-column-search v-model="filters.tfov"></table-column-search>
                    </th>
                    <th width="10%">
                        <table-column-header sort-key="apparent_field" :sort-criteria="sort" v-on:sort="sortBy">Apparent Field</table-column-header>
                        <table-column-search v-model="filters.apparent_field"></table-column-search>
                    </th>
                    <th width="10%">
                        <table-column-header sort-key="eye_relief" :sort-criteria="sort" v-on:sort="sortBy">Eye Relief</table-column-header>
                        <table-column-search v-model="filters.eye_relief"></table-column-search>
                    </th>
                    <th width="10%">
                        <table-column-header sort-key="field_stop" :sort-criteria="sort" v-on:sort="sortBy">Field Stop</table-column-header>
                        <table-column-search v-model="filters.field_stop"></table-column-search>
                    </th>
                    <th width="10%">Barrel Size</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="eyepiece in sortedEyepieces" v-bind:class="{ selected: selectedRows[eyepiece.id] && !isActiveTab('compare') }">
                    <td class="select" v-on:click="selectRow(eyepiece)"><i class="glyphicon glyphicon-ok-circle"></i></td>
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

    .table-tabs {
        border-bottom: 3px solid #3d4044;
        height: 35px;
    }

    .table-tabs ul {
        float: left;
        list-style-type: none;
        padding: 0;
        margin: 0;
        height: 30px;
    }

    .table-tabs ul li {
        border-radius: 3px 3px 0 0;
        padding: 5px 10px;
        border: 1px solid #e2e2e2;
        border-bottom: none;
        margin-right: 5px;
        float: left;
        cursor: pointer;
    }

    .table-tabs ul li.active {
        border: none;
        padding-bottom: 8px;
        background: #3d4044;
        color: #fff;
        cursor: default;
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

    const sortBy = function (sortKey) {
        this.sort.ascending = (this.sort.key == sortKey) ? !this.sort.ascending : true;
        this.sort.key = sortKey;
    };

    const isSelected = function (selectedRows, eyepiece) {
        return !this.isActiveTab('compare') ? true : selectedRows[eyepiece.id];
    };

    const updateEyepieces = function () {
        return this.eyepieces
                .filter(isSelected.bind(this, this.selectedRows))
                .filter(telescopeUtils.eyepieceFitsTelescope.bind(null, this.telescope))
                .filter(telescopeUtils.contains.bind(null, this.filters.name, 'name'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.focal_length), 'focal_length'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.magnification), 'magnification'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.exit_pupil), 'exit_pupil'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.tfov), 'tfov'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.apparent_field), 'apparent_field'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.eye_relief), 'eye_relief'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.field_stop), 'field_stop'))
                .sort(utils.compare.bind(this, this.sort.key, this.sort.ascending));
    };

    const resetSelectedRows = function () {
        this.selectedRows = this.eyepieces.reduce(function (acc, eyepiece) {
            acc[eyepiece.id] = false;
            return acc;
        }, {});
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
            field_stop: ''
        }
    };

    // View Model
    export default {
        props: ['eyepieces', 'telescope'],
        data: () => {
            return {
                sort: {
                    key: 'name',
                    ascending: true
                },
                selectedRows: {},
                isComparing: false,
                activeTab: 'all',
                filters: refreshDataFilters()
            }
        },
        created: function () {
            resetSelectedRows.call(this);

            let EYEPIECE_REGEX = /ep=(.*)/
            let hash = window.location.hash;
            if (EYEPIECE_REGEX.test(hash)) {
                let matches = hash.match(EYEPIECE_REGEX);
                let eyepieceIds = matches[1].split(',');
                eyepieceIds.forEach(id => {
                    this.selectedRows[id] = true;
                });
                this.showTab('compare');
            }
        },
        computed: {
            sortedEyepieces: updateEyepieces
        },
        methods: {
            sortBy,
            isActiveTab: function (tabName) {
                return tabName === this.activeTab;
            },
            showTab: function (tabName) {
                this.activeTab = tabName;
                this.clearFilters();
            },
            getSelectedCount: function () {
                return Object.keys(this.selectedRows).filter(key => this.selectedRows[key]).length;
            },
            selectRow: function (eyepiece) {
                this.selectedRows[eyepiece.id] = !this.selectedRows[eyepiece.id];
                if (this.isActiveTab('compare') && this.getSelectedCount() == 0) {
                    this.showTab('all');
                }
            },
            clearSelected: function () {
                resetSelectedRows.call(this);
                if (this.isActiveTab('compare')) {
                    this.showTab('all');
                }
            },
            clearFilters: function () {
                this.filters = refreshDataFilters();
            },
            getShareUrl: function () {
                let url = 'https://eyepieceplanner.com';
                let telescope = '/#t=' + this.telescope.aperture + ',' + this.telescope.focal_length + ',' + this.telescope.max_eyepiece_size;
                let eyepieces = ';ep=' + Object.keys(this.selectedRows).filter(key => this.selectedRows[key]).join(',');
                return url + telescope + eyepieces;
            },
            copyShareLink: function () {
                window.prompt("Copy the following share URL:", this.getShareUrl());
            }
        },
        filters: formatters
    };
</script>
