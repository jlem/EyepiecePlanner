<template>
    <table v-cloak class="eyepiece-table">
        <thead>
            <tr>
                <th>
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
                <th>
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
                <th v-if="telescope">
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
                <th v-if="telescope">
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
                <th v-if="telescope">
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
                <th>
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
                <th>
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
                <th>
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
                <th>Barrel Size</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="eyepiece in sortedEyepieces">
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
</template>

<style>
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

    tr:nth-child(odd) {
        background-color: #f4f4f4;
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

    const updateEyepieces = function () {
        return this.eyepieces
                .filter(telescopeUtils.contains.bind(null, this.filters.name, 'name'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.focal_length), 'focal_length'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.magnification), 'magnification'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.exit_pupil), 'exit_pupil'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.tfov), 'tfov'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.apparent_field), 'apparent_field'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.eye_relief), 'eye_relief'))
                .filter(telescopeUtils.matchesRange.bind(null, utils.parseFilterValue(this.filters.field_stop), 'field_stop'))
                .sort(utils.compare.bind(this, this.sortKey, this.sortAscending));
    }

    // View Model
    export default {
        props: ['eyepieces', 'telescope'],
        data: () => {
            return {
                sortKey: 'name',
                sortAscending: true,
                filters: {
                    name: '',
                    focal_length: '',
                    magnification: '',
                    exit_pupil: '',
                    tfov: '',
                    apparent_field: '',
                    eye_relief: '',
                    field_stop: ''
                }
            }
        },
        computed: {
            sortedEyepieces: updateEyepieces
        },
        methods: {
            sortBy: sortBy
        },
        filters: formatters,
    };
</script>
