import VueRouter from 'vue-router';
import store from './store';
import { mapGetters } from 'vuex';

'use strict';

new Vue({
	store,
	data: {
		eyepieces: window.eyepieces,
		eyepieceSets: window.eyepieceSets,
	},
	computed: {
		...mapGetters([
			'telescopes'
		])
	},
	created: function () {
		this.$store.dispatch('setTelescopes', window.telescopes);
		this.$store.dispatch('selectTelescope', window.telescopes[0]);
	}
}).$mount('#app');
