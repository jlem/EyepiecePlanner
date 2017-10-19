const append = (append, value) => value ? value + append : null;
const prepend = (prepend, value) => value ? prepend + value : null;
const numberFormat = (value, precision) => value ? parseFloat(parseFloat(value).toFixed(precision || 2)) : value;
const mm = append.bind(null, ' mm');
const deg = append.bind(null, '°');
const mag = append.bind(null, 'x');
const price = prepend.bind(null, '$');

export default {
	numberFormat,
	mm,
	deg,
	mag,
	price
};