'use strict';

const isSelected = x => x.isSelected;
const isAutoSelected = x => x.value == 'auto' && x.isSelected;
const getValue = x => x.value;
const getSelectedValues = data => data.filter(isSelected).map(getValue);
const hasSelections = data => data.filter(isSelected).length > 0;

export default {
	props: ['options', 'tooltip'], // tooltip is used to convey what "auto" means
	data: function () {
		return {
			show: false
		}
	},
	methods: {
		toggleSelection: function (option) {
			option.isSelected = !option.isSelected;

			// Hide the selection options when we pick auto, and delected all other options
			if (option.value == 'auto' && option.isSelected) {
				this.show = false;
				this.options.filter(o => o.value !== 'auto').forEach(o => o.isSelected = false);
			}

			// Deselect the auto option if any other option is selected (mutually exclusive)
			if (option.value !== 'auto') {
				this.options.find(o => o.value == 'auto').isSelected = false;
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
		getLabel: function () {
			return this.isAutoSelected() ? 'Auto' : 'Select';
		}
	}
}
