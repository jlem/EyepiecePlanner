import utils from '../utils';

const pristineTelescope = () => {
	return {
		name: null,
		focal_length: null,
		focal_ratio: null,
		aperture: null,
		max_eyepiece_size: '2',
		id: null
	}
};

const newTelescope = () => {
	return Object.assign({}, pristineTelescope(), { id: utils.randomString(5) });
}

export default {
	pristineTelescope,
	newTelescope
};
