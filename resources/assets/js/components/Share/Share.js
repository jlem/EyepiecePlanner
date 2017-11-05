'use strict';

export default {
	props: ['telescope', 'selectedEyepieces'],
	computed: {
		shareUrl: function () {
			let url = 'https://eyepieceplanner.com/#/';
			let telescope = '&t=' + this.telescope.aperture + ',' + this.telescope.focal_ratio + ',' + this.telescope.max_eyepiece_size;
			let eyepieces = '?ep=' + this.selectedEyepieces.reduce((previousValue, currentValue) => {
					previousValue.push(currentValue.id);
					return previousValue;
				}, []).join(',');
			return url + eyepieces + telescope;
		}
	}
}
