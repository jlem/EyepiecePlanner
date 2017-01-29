import telescopeUtilities from "./telescope-utils";
import formatters from "./formatters";
import utils from "./utils";

'use strict';

let telescope = {
	focal_length: 2000,
	aperture: 400,
	max_magnification: 50,
	max_pupil: 7
};

const ELEMENT = '#comparison';

// Search
const search = (eyepieces, query) => (!query) ? [] : eyepieces.filter(eyepiece => telescopeUtilities.getEyepieceDescription(eyepiece).toLowerCase().indexOf(query.toLowerCase()) > -1);

// View Model
new Vue({
	el: ELEMENT,
	data: {
		eyepieces: window.eyepieces,
		selectedEyepieces: [],
		telescope: telescope,
		searchResults: [],
		pupilReference: false,
		query: null
	},
	methods: {
		calculateMagnification: telescopeUtilities.calculateMagnification,
		calculateTrueFoV: telescopeUtilities.calculateTrueFoV,
		calculateExitPupil: telescopeUtilities.calculateExitPupil,
		calculateMaxMagnification: telescopeUtilities.calculateMaxMagnification,
		calculateLowestMagnification: telescopeUtilities.calculateLowestMagnification,
		isMagnificationTooHigh: telescopeUtilities.isMagnificationTooHigh,
		isExitPupilTooLarge: telescopeUtilities.isExitPupilTooLarge,
		getEyepieceDescription: telescopeUtilities.getEyepieceDescription,
		isSelected: utils.isSelected,
		select: function (selectedEyepieces, eyepiece) {
			this.selectedEyepices = utils.isSelected(selectedEyepieces, eyepiece)
				? utils.removeSelectionById(selectedEyepieces, eyepiece)
				: utils.addSelection(selectedEyepieces, eyepiece);
		},
		clearSelection: function () {
			this.selectedEyepieces = [];
		},
		search: function (eyepieces, query) {
			this.searchResults = search(eyepieces, query);
		},
		clearSearch: function () {
			this.query = null;
			this.search(this.query);
		},
		togglePupilReference: function () {
			this.pupilReference = !this.pupilReference;
		}
	},
	filters: formatters
});
