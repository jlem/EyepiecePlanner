const append = (append, value) => value ? value + append : null;
const prepend = (prepend, value) => value ? prepend + value : null;
const numberFormat = (value, precision) => parseFloat(value.toFixed(precision));
const mm = append.bind(null, ' mm');
const deg = append.bind(null, '°');
const mag = append.bind(null, 'x');
const price = (value) => {
	return value ? prepend('$', value.toFixed(2)) : null;
}

export default {
	numberFormat,
	mm,
	deg,
	mag,
	price
};