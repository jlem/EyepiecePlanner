import * as types from './mutation-types';
import utils from '../utils';

export default {
	[types.SET_AUTH] (state, authInfo) {
		state.auth = authInfo;
	},
	[types.ADD_SELECTION] (state, options) {
		if (!state.selections[options.group]) {
			throw new Error(`Could not find selection group '${option.sgroup}'`);
		}

		state.selections[options.group].push(options.item);
	},
	[types.REMOVE_SELECTION] (state, options) {
		if (!state.selections[options.group]) {
			throw new Error(`Could not find selection group '${options.group}'`);
		}

		let index = state.selections[options.group].findIndex(i => i[options.lookupKey] === options.item[options.lookupKey]);

		if (index > -1) {
			state.selections[options.group].splice(index, 1);
		}
	},
	[types.CLEAR_SELECTIONS] (state, group) {
		if (!state.selections[group]) {
			throw new Error(`Could not find selection group '${group}'`);
		}

		state.selections[group] = [];
	},
	[types.SELECT_TAB] (state, tab) {
		state.selectedTab = tab;
	},
	[types.SELECT_EYEPIECE] (state, eyepiece) {
		state.selectedEyepieceIDs.push(eyepiece.id);
	},
	[types.DESELECT_EYEPIECE] (state, eyepiece) {
		state.selectedEyepieceIDs.splice(state.selectedEyepieceIDs.indexOf(eyepiece.id), 1);
	},
	[types.SET_EYEPIECE_SELECTIONS] (state, eyepieceIDs) {
		state.selections.eyepieces = eyepieceIDs;
	},
	[types.SET_SELECTED_TELESCOPE] (state, telescope) {
		state.selectedTelescope = telescope;
	},
	[types.SET_EDIT_TELESCOPE] (state, telescope) {
		state.telescopeToEdit = telescope ? Object.assign({}, telescope) : null;
	},
	[types.SET_TELESCOPES] (state, telescopes) {
		state.telescopes = telescopes;
	},
	[types.ADD_TELESCOPE] (state, telescope) {
		if (!telescope.id) {
			telescope.id = utils.randomString(5);
		}
		state.telescopes.push(telescope);
	},
	[types.REMOVE_TELESCOPE] (state, telescope) {
		let index = state.telescopes.findIndex(t => t.id === telescope.id);
		if (index > -1) {
			state.telescopes.splice(index, 1);
		}
	},
	[types.UPDATE_TELESCOPE] (state, telescope) {
		// Need to mutate individual property value assignment so as to keep data binding intact.
		let storedTelescope = state.telescopes.find(t => t.id === telescope.id);
		storedTelescope = Object.assign(storedTelescope, telescope);
	},
	[types.TOGGLE_EDIT_MODAL] (state, status) {
		state.createEditMode = status;
	}
};
