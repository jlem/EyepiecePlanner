const append = (append, value) => value ? value + append : null;
const numberFormat = (value, precision) => parseFloat(value.toFixed(precision));
const mm = append.bind(null, ' mm');
const deg = append.bind(null, '°');
const mag = append.bind(null, 'x');

export default {
	numberFormat,
	mm,
	deg,
	mag
};