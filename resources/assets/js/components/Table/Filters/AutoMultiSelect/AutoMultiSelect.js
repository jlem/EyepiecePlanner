'use strict';

const isSelected = x => x.isSelected;
const isAutoSelected = x => x.value == 'auto' && x.isSelected;
const getValue = x => x.value;
const getLabel = x => x.label;
const getSelectedValues = data => data.filter(isSelected).map(getValue);
const getSelectedLabels = data => data.filter(isSelected).map(getLabel);
const getSelectedLabel = data => data.filter(isSelected).map(getLabel)[0];
const hasSelections = data => data.filter(isSelected).length > 0;
const hasMultipleSelections = data => data.filter(isSelected).length > 1;
const hasSingleSelection = data => data.filter(isSelected).length == 1;

export default {
	props: ['options', 'tooltip'], // tooltip is used to convey what "auto" means
	data: function () {
		return {
			show: false
		}
	},
	methods: {
		getAutoOption: function () {
			return this.options.find(o => o.value === 'auto');
		},
		toggleSelection: function (option) {
			// Require at least one selection
			option.isSelected = !option.isSelected;

			if (!hasSelections(this.options)) {
				this.toggleSelection(this.getAutoOption());
				return;
			}

			// Hide the selection options when we pick auto, and delected all other options
			if (option.value == 'auto' && option.isSelected) {
				this.show = false;
				this.options.filter(o => o.value !== 'auto').forEach(o => o.isSelected = false);
			}

			// Deselect the auto option if any other option is selected (mutually exclusive)
			if (option.value !== 'auto') {
				this.getAutoOption().isSelected = false;
				this.$emit('onAutoToggle', { isAutoSelected: this.isAutoSelected(), options: this.options });
			}

			this.$emit('onSelect', getSelectedValues(this.options));

			// Broadcast auto toggle event
			if (option.value == 'auto') {
				this.$emit('onAutoToggle', { isAutoSelected: this.isAutoSelected(), options: this.options });
			}
		},
		hasSelections: function () {
			return hasSelections(this.options);
		},
		isAutoSelected: function () {
			return this.options.filter(isAutoSelected).length > 0;
		},
		areMultipleSelected: function () {
			return hasMultipleSelections(this.options);
		},
		getLabel: function () {
			if (this.isAutoSelected()) {
				return 'Auto';
			} else if (this.areMultipleSelected()) {
				return 'Multi';
			} else {
				return getSelectedLabel(this.options);
			}
		}
	}
}
