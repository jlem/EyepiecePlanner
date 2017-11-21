'use strict';

const isSelected = x => x.isSelected;
const getValue = x => x.value;
const getLabel = x => x.label;
const getSelectedValues = data => data.filter(isSelected).map(getValue);
const getSelectedLabel = data => data.filter(isSelected).map(getLabel);
const hasSelections = data => data.filter(isSelected).length > 0;
const deselect = option => option.isSelected = false;

export default {
	data: function () {
		return {
			options: [
				{ label: 'Any', value: 'any', isSelected: true },
				{ label: 'Yes', value: true, isSelected: false },
				{ label: 'No', value: false, isSelected: false }
			],
			show: false,
		}
	},
	created: function () {
		this.$emit('onSelect', [true, false]);
	},
	methods: {
		isAnySelected: function () {
			return this.options[0].isSelected;
		},
		selectOption: function (option) {
			this.options.forEach(deselect);
			option.isSelected = true;
			this.show = false;

			let selectedValues = option.value == 'any' ? [true, false] : [option.value];
			this.$emit('onSelect', selectedValues);
		},
		hasSelections: function () {
			return !this.isAnySelected();
		},
		getLabel: function () {
			return getSelectedLabel(this.options)[0];
		}
	}
}
