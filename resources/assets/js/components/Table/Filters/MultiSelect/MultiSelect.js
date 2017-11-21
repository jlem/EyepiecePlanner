'use strict';

const isSelected = x => x.isSelected;
const getValue = x => x.value;
const getLabel = x => x.label;
const getSelectedValues = data => data.filter(isSelected).map(getValue);
const getSelectedLabels = data => data.filter(isSelected).map(getLabel);
const hasSelections = data => data.filter(isSelected).length > 0;
const getAllValues = data => data.reduce((accumulator, item) => {
	accumulator.push(item.value);
	return accumulator;
}, []);

export default {
	props: ['options'],
	data: function () {
		return {
			show: false,
			anySelected: true
		}
	},
	created: function () {
		if (hasSelections(this.options)) {
			this.$emit('onSelect', getSelectedValues(this.options));
		}
	},
	methods: {
		selectAny: function () {
			this.anySelected = true;
			this.options.forEach(o => o.isSelected = false);
			this.$emit('onSelect', getAllValues(this.options));
		},
		isAnySelected: function () {
			return this.anySelected;
		},
		toggleSelection: function (option) {
			this.anySelected = false;
			option.isSelected = !option.isSelected;
			this.$emit('onSelect', getSelectedValues(this.options));
		},
		hasSelections: function () {
			return hasSelections(this.options) || this.isAnySelected();
		},
		getLabel: function () {
			return this.isAnySelected() ? 'Any' : 'Select';
		}
	}
}