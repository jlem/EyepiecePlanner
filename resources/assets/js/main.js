import Vue from 'vue';
import bootstrap from './bootstrap'
import store from './store';
import router from './router';

'use strict';

new Vue({
	el: '#app',
	router,
	store,
	created: function () {
		this.$store.dispatch('setTelescopes', window.telescopes);
		this.$store.dispatch('selectTelescope', window.telescopes[0]);
		this.$store.dispatch('setAuth', window.auth);
	}
});
