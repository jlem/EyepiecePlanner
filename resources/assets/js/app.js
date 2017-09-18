
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// UI components
/// Specific Tables
Vue.component('telescopes-table', require('./components/TelescopesTable.vue'));

Vue.component('table-column-header', require('./components/TableColumnHeader.vue'));
Vue.component('table-column-search', require('./components/TableColumnSearch.vue'));
Vue.component('eyepiece-tabs', require('./components/EyepieceTabs.vue'));
Vue.component('eyepiece-table', require('./components/EyepieceTable.vue'));
Vue.component('eyepiece-filter', require('./components/EyepieceFilter.vue'));
Vue.component('telescope-form', require('./components/TelescopeForm.vue'));
Vue.component('telescope-list', require('./components/TelescopeList.vue'));
Vue.component('magnification-options', require('./components/MagnificationOptions.vue'));
Vue.component('share', require('./components/Share.vue'));
Vue.component('epp-table', require('./components/Table/Table.vue'));
Vue.component('link-cell', require('./components/Table/Cells/LinkCell.vue'));
Vue.component('info-set', require('./components/InfoSet.vue'));
