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
                        <label v-on:click="sortBy('name')">
                            Name
                            <i v-if="sortKey != 'name'" class="sort glyphicon glyphicon-minus"></i>
                            <i v-if="sortKey == 'name' && sortAscending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
                            <i v-if="sortKey == 'name' && !sortAscending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
                        </label>
                        <input type="text" v-model="filters.name">
                        <i v-if="filters.name == ''" class="glyphicon glyphicon-search"></i>
                        <i v-if="filters.name != ''" class="glyphicon glyphicon-remove" v-on:click="filters.name = ''"></i>
                    </th>
                    <th width="10%">
                        <label v-on:click="sortBy('focal_length')">
                            Focal Length
                            <i v-if="sortKey != 'focal_length'" class="sort glyphicon glyphicon-minus"></i>
                            <i v-if="sortKey == 'focal_length' && sortAscending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
                            <i v-if="sortKey == 'focal_length' && !sortAscending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
                        </label>
                        <input type="text" v-model="filters.focal_length">
                        <i v-if="filters.focal_length == ''" class="glyphicon glyphicon-search"></i>
                        <i v-if="filters.focal_length != ''" class="glyphicon glyphicon-remove" v-on:click="filters.focal_length = ''"></i>
                    </th>
                    <th width="10%" v-if="telescope">
                        <label v-on:click="sortBy('magnification')">
                            Magnification
                            <i v-if="sortKey != 'magnification'" class="sort glyphicon glyphicon-minus"></i>
                            <i v-if="sortKey == 'magnification' && sortAscending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
                            <i v-if="sortKey == 'magnification' && !sortAscending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
                        </label>
                        <input type="text" v-model="filters.magnification">
                        <i v-if="filters.magnification == ''" class="glyphicon glyphicon-search"></i>
                        <i v-if="filters.magnification != ''" class="glyphicon glyphicon-remove" v-on:click="filters.magnification = ''"></i>
                    </th>
                    <th width="10%" v-if="telescope">
                        <label v-on:click="sortBy('exit_pupil')">
                            Exit Pupil
                            <i v-if="sortKey != 'exit_pupil'" class="sort glyphicon glyphicon-minus"></i>
                            <i v-if="sortKey == 'exit_pupil' && sortAscending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
                            <i v-if="sortKey == 'exit_pupil' && !sortAscending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
                        </label>
                        <input type="text" v-model="filters.exit_pupil">
                        <i v-if="filters.exit_pupil == ''" class="glyphicon glyphicon-search"></i>
                        <i v-if="filters.exit_pupil != ''" class="glyphicon glyphicon-remove" v-on:click="filters.exit_pupil = ''"></i>
                    </th>
                    <th width="10%" v-if="telescope">
                        <label v-on:click="sortBy('tfov')">
                            True FoV
                            <i v-if="sortKey != 'tfov'" class="sort glyphicon glyphicon-minus"></i>
                            <i v-if="sortKey == 'tfov' && sortAscending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
                            <i v-if="sortKey == 'tfov' && !sortAscending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
                        </label>
                        <input type="text" v-model="filters.tfov">
                        <i v-if="filters.tfov == ''" class="glyphicon glyphicon-search"></i>
                        <i v-if="filters.tfov != ''" class="glyphicon glyphicon-remove" v-on:click="filters.tfov = ''"></i>
                    </th>
                    <th width="10%">
                        <label v-on:click="sortBy('apparent_field')">
                            Apparent Field
                            <i v-if="sortKey != 'apparent_field'" class="sort glyphicon glyphicon-minus"></i>
                            <i v-if="sortKey == 'apparent_field' && sortAscending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
                            <i v-if="sortKey == 'apparent_field' && !sortAscending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
                        </label>
                        <input type="text" v-model="filters.apparent_field">
                        <i v-if="filters.apparent_field == ''" class="glyphicon glyphicon-search"></i>
                        <i v-if="filters.apparent_field != ''" class="glyphicon glyphicon-remove" v-on:click="filters.apparent_field = ''"></i>
                    </th>
                    <th width="10%">
                        <label v-on:click="sortBy('eye_relief')">
                            Eye Relief
                            <i v-if="sortKey != 'eye_relief'" class="sort glyphicon glyphicon-minus"></i>
                            <i v-if="sortKey == 'eye_relief' && sortAscending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
                            <i v-if="sortKey == 'eye_relief' && !sortAscending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
                        </label>
                        <input type="text" v-model="filters.eye_relief">
                        <i v-if="filters.eye_relief == ''" class="glyphicon glyphicon-search"></i>
                        <i v-if="filters.eye_relief != ''" class="glyphicon glyphicon-remove" v-on:click="filters.eye_relief = ''"></i>
                    </th>
                    <th width="10%">
                        <label v-on:click="sortBy('field_stop')">
                            Field Stop
                            <i v-if="sortKey != 'field_stop'" class="sort glyphicon glyphicon-minus"></i>
                            <i v-if="sortKey == 'field_stop' && sortAscending" class="sort sort-active glyphicon glyphicon-triangle-top"></i>
                            <i v-if="sortKey == 'field_stop' && !sortAscending" class="sort sort-active glyphicon glyphicon-triangle-bottom"></i>
                        </label>
                        <input type="text" v-model="filters.field_stop">
                        <i v-if="filters.field_stop == ''" class="glyphicon glyphicon-search"></i>
                        <i v-if="filters.field_stop != ''" class="glyphicon glyphicon-remove" v-on:click="filters.field_stop = ''"></i>
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

    .eyepiece-table th input {
        width: 100%;
        font-weight: normal;
    }

    .eyepiece-table th {
        background-color: #fff;
        position: relative;
    }

    th label {
        cursor: pointer;
    }

    .sort {
        color: #aec7d8;
    }
    .sort-active {
        color: orangered;
    }

    .glyphicon-search,
    .glyphicon-remove {
        position: absolute;
        right: 15px;
        top: 37px;
    }
    .glyphicon-search {
        opacity: 0.5;
    }

    .glyphicon-remove {
        cursor: pointer;
        opacity: 0.75;
    }

    .glyphicon-remove:hover {
        opacity: 1;
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

    th label {
        display: block;
    }
</style>

<script type="text/ecmascript-6">
    'use strict';

    import formatters from '../formatters';
    import utils from '../utils';
    import telescopeUtils from '../telescope-utils';
    import { debounce } from 'lodash';

    const sortBy = function (sortKey) {
        this.sortAscending = (this.sortKey == sortKey) ? !this.sortAscending : true;
        this.sortKey = sortKey;
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
                .sort(utils.compare.bind(this, this.sortKey, this.sortAscending));
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
                sortKey: 'name',
                selectedRows: {},
                sortAscending: true,
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
