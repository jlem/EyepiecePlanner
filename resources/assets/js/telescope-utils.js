const calculateMagnification = (eyepiece, telescope) => telescope.focal_length / eyepiece.focal_length;
const calculateTrueFoV = (eyepiece, telescope) => eyepiece.apparent_field / calculateMagnification(eyepiece, telescope);
const calculateExitPupil = (eyepiece, telescope) => telescope.aperture / calculateMagnification(eyepiece, telescope);
const calculateMaxMagnification = telescope => telescope.aperture / 25.4 * telescope.max_magnification;
const calculateLowestMagnification = telescope => telescope.aperture / telescope.max_pupil;
const isMagnificationTooHigh = (eyepiece, telescope) => calculateMagnification(eyepiece, telescope) > calculateMaxMagnification(telescope);
const isExitPupilTooLarge = (eyepiece, telescope) => calculateExitPupil(eyepiece, telescope) > telescope.max_pupil;
const getEyepieceDescription = eyepiece => eyepiece.manufacturer_name + ' ' + eyepiece.product_name + ' ' + eyepiece.focal_length + 'mm ';

export default {
	calculateMagnification,
	calculateTrueFoV,
	calculateExitPupil,
	calculateMaxMagnification,
	calculateLowestMagnification,
	isMagnificationTooHigh,
	isExitPupilTooLarge,
	getEyepieceDescription
};