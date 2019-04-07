'use strict';

const formatEyepieceTableRow = eyepiece => {
	return `${eyepiece.focal_length}mm ${eyepiece.name} | ${eyepiece.magnification}x | ${eyepiece.exit_pupil}mm | ${eyepiece.tfov}°`;
}

export default {
	props: ['telescopes', 'selectedTelescope', 'selectedEyepieces'],
	data() {
		return {
			showRedditTableModal: false
		}
	},
	created() {
		window.addEventListener('keyup', this.keyUp.bind(this));
	},
	destroyed() {
		window.removeEventListener('keyup', this.keyUp.bind(this));
	},
	methods: {
		keyUp(event) {
			// escape
			if(event.keyCode == 27) {
				this.closeModal();
			}
		},
		selectTelescope(telescope) {
			this.$store.dispatch('selectTelescope', telescope);
		},
		closeModal() {
			this.$emit('closeClicked');
		}
	},
	computed: {
		table: function () {
			let lines = [
				`Eyepiece | Magnification | Exit Pupil | True FOV`,
				`---|---|---|---`
			];

			return lines
				.concat(this.selectedEyepieces.map(formatEyepieceTableRow))
				.join("\n");
		}
	}
}
