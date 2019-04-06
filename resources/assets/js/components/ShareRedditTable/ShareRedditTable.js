'use strict';

export default {
	props: ['telescope', 'selectedEyepieces'],
	data: function() {
		return {
			showRedditTableModal: false
		}
	},
	computed: {
		eyepieces: function () {
			console.log(this.selectedEyepieces);
		},
	}
}
