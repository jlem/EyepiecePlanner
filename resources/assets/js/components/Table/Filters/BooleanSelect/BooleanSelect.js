'use strict';

const isSelected = x => x.isSelected;
const getLabel = x => x.label;
const getSelectedLabel = data => data.filter(isSelected).map(getLabel);
const deselect = option => option.isSelected = false;

export default {
	props: ['initialSelectedOption'],
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
		this.selectOption(this.getInitialSelection(this.initialSelectedOption, this.options));
	},
	methods: {
		getInitialSelection: function (initialSelection, options) {
			switch(initialSelection) {
				case 'true':
					return options[1];
				case 'false':
					return options[2];
				default:
					return options[0];
			}
		},
		isAnySelected: function () {
			return this.options[0].isSelected;
		},
		selectOption: function (option) {
			this.options.forEach(deselect);
			option.isSelected = true;
			this.show = false;

			// Allowed values is a list of all the values that should be matched against when filtering
			// When 'any' is selected, it means we are saying "Any item whose target key has a value of 'true' OR 'false' is allowed"
			// When 'true' is selected, it means "Only items whose target key also has a value of 'true' should pass through the filter"
			// When 'false' is selected, it means "Only items whose target key also has a value of 'false' should pass through the filter"
			let allowedValues = option.value == 'any' ? [true, false] : [option.value];
			this.$emit('onSelect', allowedValues);
		},
		hasSelections: function () {
			return !this.isAnySelected();
		},
		getLabel: function () {
			return getSelectedLabel(this.options)[0];
		}
	}
}
