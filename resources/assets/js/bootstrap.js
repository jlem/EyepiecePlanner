import Vue from 'vue';
import VueResource from 'vue-resource';
import TelescopesTable from './components/TelescopesTable.vue';
import TableColumnHeader from './components/TableColumnHeader.vue';
import EyepieceTabs from './components/EyepieceTabs.vue';
import TelescopeForm from './components/TelescopeForm.vue';
import TelescopeTabList from './components/TelescopeTabList.vue';
import MagnificationOptions from './components/MagnificationOptions.vue';
import Share from './components/Share/Share.vue';
import ShareRedditTable from './components/ShareRedditTable/ShareRedditTable.vue';
import EppTable from './components/Table/Table.vue';
import LinkCell from './components/Table/Cells/LinkCell.vue';
import BooleanCell from './components/Table/Cells/BooleanCell.vue';
import ComputedFieldStopCell from './components/Table/Cells/ComputedFieldStopCell.vue';
import ComputedTFOVCell from './components/Table/Cells/ComputedTFOVCell.vue';
import InfoSet from './components/InfoSet.vue';

// Table Components / Filters
import MultiSelect from './components/Table/Filters/MultiSelect/MultiSelect.vue';
import BooleanSelect from './components/Table/Filters/BooleanSelect/BooleanSelect.vue';
import AutoMultiSelect from './components/Table/Filters/AutoMultiSelect/AutoMultiSelect.vue';
import Search from './components/Table/Filters/Search/Search.vue';

// Register plugins
Vue.use(VueResource);

// Register components
Vue.component('telescopes-table', TelescopesTable);
Vue.component('table-column-header', TableColumnHeader);
Vue.component('eyepiece-tabs', EyepieceTabs);
Vue.component('telescope-form', TelescopeForm);
Vue.component('telescope-tab-list', TelescopeTabList);
Vue.component('magnification-options', MagnificationOptions);
Vue.component('share', Share);
Vue.component('share-reddit-table', ShareRedditTable);
Vue.component('epp-table', EppTable);
Vue.component('link-cell', LinkCell);
Vue.component('boolean-cell', BooleanCell);
Vue.component('computed-field-stop-cell', ComputedFieldStopCell);
Vue.component('computed-tfov-cell', ComputedTFOVCell);
Vue.component('info-set', InfoSet);
Vue.component('search', Search);
Vue.component('multi-select', MultiSelect);
Vue.component('boolean-select', BooleanSelect);
Vue.component('auto-multi-select', AutoMultiSelect);

// Register Middleware
Vue.http.interceptors.push((request, next) => {
	request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
	next();
});

export default {}
