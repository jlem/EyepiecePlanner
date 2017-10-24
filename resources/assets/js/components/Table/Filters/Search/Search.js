'use strict';

export default {
	props: ['value'],
	methods: {
		emitValue: function (value) {
			this.$emit('input', value);
		}
	}
}
