import utils from './utils';
import formatters from './formatters';

const calculateMagnification = (eyepiece, telescope) => telescope.focal_length / eyepiece.focal_length;
const calculateTrueFoVFieldStop = (eyepiece, telescope) => eyepiece.field_stop / telescope.focal_length * 57.3;
const calculateTrueFovApparentField = (eyepiece, telescope) => eyepiece.apparent_field / calculateMagnification(eyepiece, telescope);
const calculateFieldStopFromAFOV = eyepiece => (eyepiece.focal_length * eyepiece.apparent_field) / 57.3;
const calculateTrueFoV = (eyepiece, telescope) => eyepiece.field_stop ? calculateTrueFoVFieldStop(eyepiece, telescope) : calculateTrueFovApparentField(eyepiece, telescope);
const getFieldStop = eyepiece => eyepiece.field_stop ? eyepiece.field_stop : calculateFieldStopFromAFOV(eyepiece);
const calculateExitPupil = (eyepiece, telescope) => eyepiece.focal_length / telescope.focal_ratio;
const calculateMaxMagnification = telescope => telescope.aperture / 25.4 * telescope.max_magnification;
const calculateLowestMagnification = telescope => telescope.aperture / telescope.max_pupil;
const isMagnificationTooHigh = (eyepiece, telescope) => calculateMagnification(eyepiece, telescope) > calculateMaxMagnification(telescope);
const isExitPupilTooLarge = (eyepiece, telescope) => calculateExitPupil(eyepiece, telescope) > telescope.max_pupil;
const getEyepieceName = eyepiece => eyepiece.manufacturer_name + ' ' + eyepiece.product_name;
const getEyepieceDescription = eyepiece => getEyepieceName(eyepiece) + ' ' + eyepiece.focal_length + 'mm ';

const computeEyepieceProperties = (eyepieces, telescope) => {
	return eyepieces.map((eyepiece) => {
		let computedProperties = {
			tfov: formatters.numberFormat(calculateTrueFoV(eyepiece, telescope)),
			magnification: formatters.numberFormat(calculateMagnification(eyepiece, telescope)),
			exit_pupil: formatters.numberFormat(calculateExitPupil(eyepiece, telescope)),
			field_stop_computed: formatters.numberFormat(getFieldStop(eyepiece)),
			name: getEyepieceName(eyepiece)
		};

		return Object.assign({}, eyepiece, computedProperties);
	});
};

const eyepieceFitsTelescope = (telescope, eyepiece) => {
	return (telescope.max_eyepiece_size === '1.25' && eyepiece.barrel_size.includes('1.25')) ||
		(telescope.max_eyepiece_size === '2' && eyepiece.barrel_size !== '3') ||
		telescope.max_eyepiece_size === '3'
};

const matchesRange = (inputRange, property, eyepiece) => utils.matchesRange(inputRange.min, inputRange.max, eyepiece[property]);
const matchesPrice = (inputRange, eyepiece) => {
	if (inputRange.min === '' && inputRange.max === '') {
		return true; // No filtering should be done, allow everything to pass through
	}

	if (eyepiece.price.length === 0) {
		return false; // Unknown prices should not match
	}

	let prices = eyepiece.price.split('-');

	if (prices.length === 1) { // Check just the one price against the range
		return utils.matchesRange(inputRange.min, inputRange.max, +prices[0].trim());
	} else { // Check both prices against the input ranges, and vice-verse
		let priceRange = utils.makeRange(eyepiece.price);
		return utils.matchesRange(priceRange.min, priceRange.max, +inputRange.min) ||
		utils.matchesRange(priceRange.min, priceRange.max, +inputRange.max) ||
		utils.matchesRange(inputRange.min, inputRange.max, +priceRange.min) ||
		utils.matchesRange(inputRange.min, inputRange.max, +priceRange.max);
	}
};

const contains = (value, property, eyepiece) => eyepiece[property].toLowerCase().includes(value.toLowerCase());

export default {
	calculateMagnification,
	calculateTrueFoV,
	calculateTrueFoVFieldStop,
	calculateExitPupil,
	calculateMaxMagnification,
	calculateLowestMagnification,
	isMagnificationTooHigh,
	isExitPupilTooLarge,
	getEyepieceDescription,
	computeEyepieceProperties,
	eyepieceFitsTelescope,
	matchesRange,
	matchesPrice,
	contains
};
