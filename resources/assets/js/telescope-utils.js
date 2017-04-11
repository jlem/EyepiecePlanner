import utils from './utils';

const calculateMagnification = (eyepiece, telescope) => telescope.focal_length / eyepiece.focal_length;
const calculateTrueFoVFieldStop = (eyepiece, telescope) => eyepiece.field_stop / telescope.focal_length * 57.3;
const calculateTrueFovApparentField = (eyepiece, telescope) => eyepiece.apparent_field / calculateMagnification(eyepiece, telescope);
const calculateTrueFoV = (eyepiece, telescope) => eyepiece.field_stop ? calculateTrueFoVFieldStop(eyepiece, telescope) : calculateTrueFovApparentField(eyepiece, telescope);
const calculateExitPupil = (eyepiece, telescope) => telescope.aperture / calculateMagnification(eyepiece, telescope);
const calculateMaxMagnification = telescope => telescope.aperture / 25.4 * telescope.max_magnification;
const calculateLowestMagnification = telescope => telescope.aperture / telescope.max_pupil;
const isMagnificationTooHigh = (eyepiece, telescope) => calculateMagnification(eyepiece, telescope) > calculateMaxMagnification(telescope);
const isExitPupilTooLarge = (eyepiece, telescope) => calculateExitPupil(eyepiece, telescope) > telescope.max_pupil;
const getEyepieceName = eyepiece => eyepiece.manufacturer_name + ' ' + eyepiece.product_name;
const getEyepieceDescription = eyepiece => getEyepieceName(eyepiece) + ' ' + eyepiece.focal_length + 'mm ';

const computeEyepieceProperties = (eyepieces, telescope) => {
	return eyepieces.map((eyepiece) => {
		let computedProperties = {
			tfov: calculateTrueFoV(eyepiece, telescope),
			magnification: calculateMagnification(eyepiece, telescope),
			exit_pupil: calculateExitPupil(eyepiece, telescope),
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

const matchesRange = (range, property, eyepiece) => utils.matchesRange(range.min, range.max, eyepiece[property]);
const contains = (value, property, eyepiece) => eyepiece[property].includes(value);

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
	contains
};
