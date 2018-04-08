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
			anySelected: true,
			multipleSelected: false,
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
		isMultipleSelected: function () {
			return this.multipleSelected;
		},
		toggleSelection: function (option) {
			this.anySelected = false;
			option.isSelected = !option.isSelected;
			let selectedValues = getSelectedValues(this.options);
			if (this.selectedValues.length > 1) {
				this.multipleSelected = true;
			}
			this.$emit('onSelect', selectedValues);
		},
		hasSelections: function () {
			return hasSelections(this.options) || this.isAnySelected();
		},
		getLabel: function () {
			if (this.isAnySelected()) {
				return 'Any';
			} else if (this.isMultipleSelected()) {
				return 'Multi';
			} else {
				return getSelectedLabels(this.options)[0];
			}
		}
	}
}