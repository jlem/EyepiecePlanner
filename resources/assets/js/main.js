import VueRouter from 'vue-router';
import store from './store';
import { mapGetters } from 'vuex';

import EyepieceList from './pages/EyepieceList.vue';
import EyepieceDetails from './pages/EyepieceDetails.vue';
import TelescopeList from './pages/TelescopeList.vue';
import TelescopeDetails from './pages/TelescopeDetails.vue';

const routes = [
	{ path: '/', component: EyepieceList },
	{ path: '/telescopes', component: TelescopeList },
	{ path: '/telescopes/:id', component: TelescopeDetails, props: true },
	{ path: '/eyepiece/:id', component: EyepieceDetails, props: true }
];

const router = new VueRouter({
	routes
});

'use strict';

new Vue({
	router,
	store,
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
