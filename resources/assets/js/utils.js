const randomString = length => Math.random().toString(36).substring(1, length);
const isString = value => typeof value === 'string' || value instanceof String;
const findIndexByProperty = (property, items, item) => items.findIndex(x => x[property] === item[property]);
const findIndexById = findIndexByProperty.bind(null, 'id');
const isSelected = (items, item) => findIndexByProperty('id', items, item) > -1;
const addSelection = (items, item) => { items.push(item); return items };
const removeSelection = (locator, items, item) => { items.splice(locator(items, item), 1); return items };
const matchesRange = (min, max, value) => {
	value = value ? parseFloat(parseFloat(value).toFixed(2)) : value;
	let isMin = min === '' || value >= Number(min);
	let isMax = max === '' || value <= Number(max);
	return isMin && isMax;
};

const compare = function (key, alternativeKey, sortAscending, a, b) {
	if (a[key] > b[key]) {
		return sortAscending ? 1 : -1;
	} else if (a[key] < b[key]) {
		return sortAscending ? -1 : 1;
	} else {
		// In the event of a tie, sort by the given subKey
		if (a[alternativeKey] > b[alternativeKey]) {
			return 1;
		} else if (a[alternativeKey] < b[alternativeKey]) {
			return -1;
		} else {
			return 0;
		}
	}
};

/**
 *
 * @param {string} value
 * @returns {min: Number, max: Number}
 */
let makeRange = function (value) {
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

export default {
	findIndexByProperty,
	findIndexById,
	isSelected,
	addSelection,
	removeSelection,
	matchesRange,
	compare,
	makeRange,
	isString,
	randomString
};
