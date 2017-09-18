import utils from './utils';

/**
 * Does a substring lookup of the given object property and search value
 * @param {string} filterValue
 * @param {string} dataKey
 * @param {Object} dataValue
 * @returns {boolean}
 */
export const contains = (filterValue, dataKey, dataValue) => {
	if (!utils.isString(dataValue[dataKey])) {
		throw new Error("Attempted to do a substring search on a non-string value. This error likely occurred because the `contains` search filter is the wrong filter to use for the given table column's data type.");
	}

	return dataValue[dataKey].toLowerCase().includes(filterValue.toLowerCase());
};

/**
 * Parses and converts the given filter value into a range, and then checks to see if the object property value falls within that range
 * @param {string} searchValue
 * @param {string} dataKey
 * @param {Object} dataValue
 * @returns {boolean}
 */
export const numericRange = (searchValue, dataKey, dataValue) => {
	// Convert given filter input value to a range object
	let searchRange = utils.makeRange(searchValue);

	// Do comparison
	let isGreaterThanOrEqualToMin = searchRange.min === null || +dataValue[dataKey] >= searchRange.min;
	let isLessThanOrEqualToMax = searchRange.max === null || +dataValue[dataKey] <= searchRange.max;
	return isGreaterThanOrEqualToMin && isLessThanOrEqualToMax;
};
