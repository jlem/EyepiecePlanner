
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router';
import RegionList from './pages/admin/RegionList.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);

Vue.component('table-column-header', require('./components/TableColumnHeader.vue'));
Vue.component('search', require('./components/Table/Filters/Search/Search.vue'));
Vue.component('multi-select', require('./components/Table/Filters/MultiSelect/MultiSelect.vue'));
Vue.component('eyepiece-tabs', require('./components/EyepieceTabs.vue'));
Vue.component('eyepiece-filter', require('./components/EyepieceFilter.vue'));
Vue.component('telescope-form', require('./components/TelescopeForm.vue'));
Vue.component('telescope-list', require('./components/TelescopeList.vue'));
Vue.component('epp-table', require('./components/Table/Table.vue'));
Vue.component('link-cell', require('./components/Table/Cells/LinkCell.vue'));

const routes = [
	{ path: '/', component: { template: '<div>foo</div>' } },
	{ path: '/region', component: RegionList }
];

const router = new VueRouter({
	routes
});

new Vue({
	router
}).$mount('#app');
