'use strict';

const isSelected = x => x.isSelected;
const getValue = x => x.value;
const getLabel = x => x.label;
const getSelectedValues = data => data.filter(isSelected).map(getValue);
const getSelectedLabels = data => data.filter(isSelected).map(getLabel);
const hasSelections = data => data.filter(isSelected).length > 0;

export default {
	props: ['options'],
	data: function () {
		return {
			show: false
		}
	},
	methods: {
		toggleSelection: function (option) {
			option.isSelected = !option.isSelected;
			this.$emit('onSelect', getSelectedValues(this.options));
		},
		hasSelections: function () {
			return hasSelections(this.options);
		},
		getLabel: function () {
			return 'Select';
		},
		getTooltip: function () {
			return getSelectedLabels(this.options).join(', ');
		}
	}
}