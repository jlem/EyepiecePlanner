const findIndexByProperty = (property, items, item) => items.findIndex(x => x[property] === item[property]);
const findIndexById = findIndexByProperty.bind(null, 'id');
const isSelected = (items, item) => findIndexByProperty('id', items, item) > -1;
const addSelection = (items, item) => { items.push(item); return items };
const removeSelection = (locator, items, item) => { items.splice(locator(items, item), 1); return items };
const matchesRange = (min, max, value) => {
	value = value ? parseFloat(value.toFixed(2)) : value;
	let isMin = min === '' || value >= Number(min);
	let isMax = max === '' || value <= Number(max);
	return isMin && isMax;
};

const compare = function (key, sortAscending, a, b) {
	let comparison = sortAscending ? a[key] > b[key] : a[key] < b[key];
	return comparison ? 1 : -1;
};

let parseFilterValue = function (value) {
	const MATCHES_RANGE = /(.+)-(.*)/; // important - we want to match this pattern even when nothing has been typed after '-', so we capture 0 or more characters
	const MATCHES_LESS_THAN = /<(.*)/; // important - we want to match this pattern even when nothing has been typed after '<', so we capture 0 or more characters
	const MATCHES_GREATER_THAN = />(.*)/; // important - we want to match this pattern even when nothing has been typed after '>', so we capture 0 or more characters
	const MATCHES_APPROXIMATE = /~(.+)/;
	let min = '';
	let max = '';

	if (MATCHES_APPROXIMATE.test(value)) {
		let matchedValue = +value.match(MATCHES_APPROXIMATE)[1].trim();
		min = (matchedValue * .9) + ''; // dirty - need to convert back to a string since it's converted back to a number later
		max = (matchedValue * 1.1) + '';
	}
	else if (MATCHES_RANGE.test(value)) {
		let matches = value.match(MATCHES_RANGE);
		min = matches[1].trim();
		max = matches[2].trim();
	}
	else if (MATCHES_LESS_THAN.test(value)) {
		let matches = value.match(MATCHES_LESS_THAN);
		max = matches[1].trim();
	}
	else if (MATCHES_GREATER_THAN.test(value)) {
		let matches = value.match(MATCHES_GREATER_THAN);
		min = matches[1].trim();
	}
	else if (!isNaN(value)) {
		min = value.trim();
		max = min;
	}

	return { min, max };
};

export default {
	findIndexByProperty,
	findIndexById,
	isSelected,
	addSelection,
	removeSelection,
	matchesRange,
	compare,
	parseFilterValue
};
