const append = (append, value) => value ? value + append : null;
const prepend = (prepend, value) => value ? prepend + value : null;
const numberFormat = (value, precision) => value ? parseFloat(parseFloat(value).toFixed(precision)) : value;
const mm = value => append(' mm', numberFormat(value, 2));
const deg = value => append('°', numberFormat(value, 2));
const mag = value => append('x', numberFormat(value, 2));
const price = value => prepend('$', value);

export default {
	numberFormat,
	mm,
	deg,
	mag,
	price
};