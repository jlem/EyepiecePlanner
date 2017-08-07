import store from './store';
import { mapGetters } from 'vuex';

'use strict';

new Vue({
	el: "#app",
	store,
	data: {
		eyepieces: window.eyepieces,
		eyepieceSets: window.eyepieceSets,
		listConfig: [
			{
				tab: 'All Eyepieces',
				showCount: false,
				hiddenFn: () => false,
				allowSelection: true,
				filterBySelection: false,
				highlightSelections: true
			},
			{
				tab: 'Compare',
				showCount: true,
				hiddenFn: (state) => state.selectedEyepieceIDs.length === 0,
				allowSelection: true,
				filterBySelection: true,
				highlightSelections: false
			}
		]
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
});
