import Vue from 'vue';
import VueResource from 'vue-resource';
import TelescopesTable from './components/TelescopesTable.vue';
import TableColumnHeader from './components/TableColumnHeader.vue';
import TableColumnSearch from './components/TableColumnSearch.vue';
import EyepieceTabs from './components/EyepieceTabs.vue';
import EyepieceTable from './components/EyepieceTable.vue';
import EyepieceFilter from './components/EyepieceFilter.vue';
import TelescopeForm from './components/TelescopeForm.vue';
import TelescopeList from './components/TelescopeList.vue';
import MagnificationOptions from './components/MagnificationOptions.vue';
import Share from './components/Share.vue';
import EppTable from './components/Table/Table.vue';
import LinkCell from './components/Table/Cells/LinkCell.vue';
import InfoSet from './components/InfoSet.vue';

// Register plugins
Vue.use(VueResource);

// Register components
Vue.component('telescopes-table', TelescopesTable);
Vue.component('table-column-header', TableColumnHeader);
Vue.component('table-column-search', TableColumnSearch);
Vue.component('eyepiece-tabs', EyepieceTabs);
Vue.component('eyepiece-table', EyepieceTable);
Vue.component('eyepiece-filter', EyepieceFilter);
Vue.component('telescope-form', TelescopeForm);
Vue.component('telescope-list', TelescopeList);
Vue.component('magnification-options', MagnificationOptions);
Vue.component('share', Share);
Vue.component('epp-table', EppTable);
Vue.component('link-cell', LinkCell);
Vue.component('info-set', InfoSet);

// Register Middleware
Vue.http.interceptors.push((request, next) => {
	request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
	next();
});

export default {}
