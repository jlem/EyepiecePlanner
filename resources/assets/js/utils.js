const randomString = length => Math.random().toString(36).substring(1, length);
const isString = value => typeof value === 'string' || value instanceof String;
const findIndexByProperty = (property, items, item) => items.findIndex(x => x[property] === item[property]);
const findIndexById = findIndexByProperty.bind(null, 'id');
const isSelected = (items, item) => findIndexByProperty('id', items, item) > -1;
const addSelection = (items, item) => { items.push(item); return items };
const removeSelection = (locator, items, item) => { items.splice(locator(items, item), 1); return items };

/**
 * Checks to see if the given value falls between the given min and max range
 * @param {String|Number} min - the minimum value of the range
 * @param {String|Number} max - the maximum value of the range
 * @param {String|Number} value - the value to compare
 * @returns {boolean}
 */
const matchesRange = (min, max, value) => {
	value = value ? parseFloat(value).toFixed(2) : value;
	let isGreaterThanOrEqualToMin = min === '' || Number(value) >= Number(min);
	let isLessThanOrEqualToMax = max === '' || Number(value) <= Number(max);
	return isGreaterThanOrEqualToMin && isLessThanOrEqualToMax;
};

/**
 * Sort function for comparing range values formatted as a string (e.g "50.00 - 60.00")
 * @param {String} key - the data key to use to look up the value from the given a/b object
 * @param {String} alternativeKey - the subsort key for when there is a tie with the primary key's value
 * @param {Boolean} sortAscending - the sort direction
 * @param {Object} a - the object to be compared
 * @param {Object} b - the other object to be compared
 * @returns {Number} - either 1, -1, or 0 (needed for using as a sort function)
 */
const compareRange = (key, alternativeKey, sortAscending, a, b) => {
	// Some values may take the form of a range and be formatted like as a string: "50.00 - 60.00"
	// For simplicty's sake, we only care about comparing the lower value of the range,
	// so below we split on the range delimeter, grab the first value, and turn it into a float for reliable comparison.
	let left = parseFloat(a[key].split('-')[0].trim() || "0");
	let right = parseFloat(b[key].split('-')[0].trim() || "0");
	let leftAlt = a[alternativeKey];
	let rightAlt = b[alternativeKey];

	return subSort(sortAscending, left, right, leftAlt, rightAlt);
};

/**
 * Sort function for comparing range values formatted as a string (e.g "50.00 - 60.00")
 * @param {String} key - the data key to use to look up the value from the given a/b object
 * @param {String} alternativeKey - the subsort key for when there is a tie with the primary key's value
 * @param {Boolean} sortAscending - the sort direction
 * @param {Object} a - the object to be compared
 * @param {Object} b - the other object to be compared
 * @returns {Number} - either 1, -1, or 0 (needed for using as a sort function)
 */
const compare = (key, alternativeKey, sortAscending, a, b) => {
	let left = a[key];
	let right = b[key];
	let leftAlt = a[alternativeKey];
	let rightAlt = b[alternativeKey];

	return subSort(sortAscending, left, right, leftAlt, rightAlt);
};

/**
 * Sort function for comparing range values formatted as a string (e.g "50.00 - 60.00")
 * @param {*} a - the primary value to be compared
 * @param {*} b - the other primary value to be compared
 * @param {*} aAlt - the secondary tiebreaker value to be compared
 * @param {*} bAlt - the other secondary tiebreaker value to be compared
 * @returns {Number} - either 1, -1, or 0 (needed for using as a sort function)
 */
const subSort = (sortAscending, a, b, aAlt, bAlt) => {
	if (a > b) {
		return sortAscending ? 1 : -1;
	} else if (a < b) {
		return sortAscending ? -1 : 1;
	} else {
		// In the event of a tie, sort by the given subKey
		if (aAlt > bAlt) {
			return 1;
		} else if (aAlt < bAlt) {
			return -1;
		} else {
			return 0;
		}
	}
}

/**
 *
 * @param {String} value
 * @returns {min: Number, max: Number}
 */
const makeRange = value => {
	const MATCHES_RANGE = /(.+)-(.*)/; // important - we want to match this pattern even when nothing has been typed after '-', so we capture 0 or more characters
	const MATCHES_LESS_THAN = /<(.*)/; // important - we want to match this pattern even when nothing has been typed after '<', so we capture 0 or more characters
	const MATCHES_GREATER_THAN = />(.*)/; // important - we want to match this pattern even when nothing has been typed after '>', so we capture 0 or more characters
	const MATCHES_APPROXIMATE = /~(.+)/;

	let min = null;
	let max = null;

	if (!value) {
		return { min: null, max: null };
	}

	if (MATCHES_APPROXIMATE.test(value)) {
		let matchedValue = +value.match(MATCHES_APPROXIMATE)[1].trim();
		min = (matchedValue * .9);
		max = (matchedValue * 1.1);
	}
	else if (MATCHES_RANGE.test(value)) {
		let matches = value.match(MATCHES_RANGE);
		min = +matches[1].trim();
		max = +matches[2].trim();
	}
	else if (MATCHES_LESS_THAN.test(value)) {
		let matches = value.match(MATCHES_LESS_THAN);
		max = +matches[1].trim();
	}
	else if (MATCHES_GREATER_THAN.test(value)) {
		let matches = value.match(MATCHES_GREATER_THAN);
		min = +matches[1].trim();
	}
	else if (!isNaN(value)) {
		min = +value.trim();
		max = min;
	} else {
		min = null;
		max = null;
	}

	return {
		min, max
	};
};

/**
 * Responsible for extracting eyepiece ID list, and telescope parameters from the URL
 * @param {String} url
 */
const parseUrl = url => {

}

export default {
	findIndexByProperty,
	findIndexById,
	isSelected,
	addSelection,
	removeSelection,
	matchesRange,
	compare,
	compareRange,
	makeRange,
	isString,
	randomString
};
