const findIndexByProperty = (property, items, item) => items.findIndex(x => x[property] === item[property]);
const findIndexById = findIndexByProperty.bind(null, 'id');
const isSelected = (items, item) => findIndexByProperty('id', items, item) > -1;
const addSelection = (items, item) => { items.push(item); return items };
const removeSelection = (locator, items, item) => { items.splice(locator(items, item), 1); return items };
const removeSelectionById = removeSelection.bind(null, findIndexById);

export default {
	findIndexByProperty,
	findIndexById,
	isSelected,
	addSelection,
	removeSelection,
	removeSelectionById
};