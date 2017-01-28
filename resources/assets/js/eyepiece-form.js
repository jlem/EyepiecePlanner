'use strict';

let telescope = {
	focal_length: 2000,
	aperture: 400,
	max_magnification: 50,
	max_pupil: 7
};

// Formatters
const append = (append, value) => value ? value + append : null;
const numberFormat = (value, precision) => parseFloat(value.toFixed(precision));

// Search
const getEyepieceDescription = eyepiece => eyepiece.manufacturer_name + ' ' + eyepiece.product_name + ' ' + eyepiece.focal_length + 'mm ';
const isSelected = (selectedEyepiecesMap, eyepiece) => selectedEyepiecesMap.indexOf(eyepiece.id) > -1;
const search = (eyepieces, query) => (!query) ? [] : eyepieces.filter(eyepiece => getEyepieceDescription(eyepiece).toLowerCase().indexOf(query.toLowerCase()) > -1);

// Telescope calculations
const calculateMagnification = (eyepiece, telescope) => telescope.focal_length / eyepiece.focal_length;
const calculateTrueFoV = (eyepiece, telescope) => eyepiece.apparent_field / calculateMagnification(eyepiece, telescope);
const calculateExitPupil = (eyepiece, telescope) => telescope.aperture / calculateMagnification(eyepiece, telescope);
const calculateMaxMagnification = telescope => telescope.aperture / 25.4 * telescope.max_magnification;
const calculateLowestMagnification = telescope => telescope.aperture / telescope.max_pupil;
const isMagnificationTooHigh = (eyepiece, telescope) => calculateMagnification(eyepiece, telescope) > calculateMaxMagnification(telescope);
const isExitPupilTooLarge = (eyepiece, telescope) => calculateExitPupil(eyepiece, telescope) > telescope.max_pupil;

// View Model
new Vue({
	el: '#comparison',
	data: {
		eyepieces: window.eyepieces,
		selectedEyepieces: [],
		selectedEyepiecesMap: [],
		telescope: telescope,
		searchResults: [],
		pupilReference: false,
		query: null
	},
	methods: {
		calculateMagnification,
		calculateTrueFoV,
		calculateExitPupil,
		calculateMaxMagnification,
		calculateLowestMagnification,
		isMagnificationTooHigh,
		isExitPupilTooLarge,
		getEyepieceDescription,
		isSelected,
		select: function (eyepiece, event) {
			isSelected(this.selectedEyepiecesMap, eyepiece)
				? this.removeSelection(eyepiece)
				: this.addSelection(eyepiece)
		},
		addSelection: function (eyepiece) {
			this.selectedEyepieces.push(eyepiece);
			this.selectedEyepiecesMap.push(eyepiece.id);
		},
		removeSelection: function (eyepiece) {
			const index = this.selectedEyepiecesMap.indexOf(eyepiece.id);
			this.selectedEyepieces.splice(index, 1);
			this.selectedEyepiecesMap.splice(index, 1);
		},
		clearSelection: function () {
			this.selectedEyepieces = [];
			this.selectedEyepiecesMap = [];
		},
		search: function (query) {
			this.searchResults = search(this.eyepieces, query);
		},
		clearSearch: function () {
			this.query = null;
			this.search(this.query);
		},
		togglePupilReference: function () {
			this.pupilReference = !this.pupilReference;
		}
	},
	filters: {
		append: append,
		mm: append.bind(null, ' mm'),
		deg: append.bind(null, '°'),
		mag: append.bind(null, 'x'),
		numberFormat: numberFormat
	}
});