import utils from '../utils';

/**
 * Regex explanation so you understand this later:
 * ep=(.+?) capture everything after finding a match for ep=, but don't be greedy about it
 * By not being greedy about the capturing, we can stop the capturing once we reach the first match, rather than any match
 * (?:&|$) start non-capturing group with alternate match for ampersand (&) or line end ($)
 * The presence of this pattern immediately after the (.+?) capture group will allow matching where the query param may or may not be the last one
 * and also prohibits the capturing of characters should it NOT be the last one
 *
 * @see https://regex101.com/r/IGamJL/2
 * @type {RegExp}
 */
const EYEPIECE_REGEX = /ep=(.+?)(?:&|$)/;
const TELESCOPE_REGEX = /t=(.+?)(?:&|$)/;

const isSharing = url => EYEPIECE_REGEX.test(url) || TELESCOPE_REGEX.test(url);

const getSharedEyepieceIDs = url => {
	if (!EYEPIECE_REGEX.test(url)) {
		return null;
	}

	let matches = url.match(EYEPIECE_REGEX);
	return matches[1].split(',').map(id => +id);
};

const getSharedTelescope = url => {
	if (!TELESCOPE_REGEX.test(url)) {
		return null;
	}

	let matches = url.match(TELESCOPE_REGEX);
	let telescopeProperties = matches[1].split(',').map(id => +id);

	// Create a new telescope from the hash values
	let telescope = {
		name: 'Custom Telescope',
		aperture: +telescopeProperties[0],
		focal_ratio: +telescopeProperties[1],
		focal_length: +telescopeProperties[0] * +telescopeProperties[1],
		max_eyepiece_size: telescopeProperties[2],
		id: utils.randomString(5)
	};

	return telescope;
};

export default {
	getSharedEyepieceIDs,
	getSharedTelescope,
	isSharing
}