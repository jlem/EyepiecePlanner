import * as types from './mutation-types';
import utils from '../utils';
import telescopeFactoryService from '../services/telescope-factory-service';

export default {
	setAuth({ commit }, authInfo) {
		commit(types.SET_AUTH, authInfo);
	},
	setTelescopeToEdit({ commit }, telescope) {
		commit(types.SET_EDIT_TELESCOPE, telescope);
	},
	openCreateEditModal({ commit }, telescope) {
		if (telescope) {
			commit(types.SET_EDIT_TELESCOPE, telescope);
		}
		commit(types.TOGGLE_EDIT_MODAL, true);
	},
	toggleSelection({ commit, state }, options) {
		let index = state.selections[options.group].findIndex(i => i[options.lookupKey] === options.item[options.lookupKey]);
		if (index > -1) {
			commit(types.REMOVE_SELECTION, options);
		} else {
			commit(types.ADD_SELECTION, options);
		}
	},
	addSelection({ commit }, options) {
		commit(types.ADD_SELECTION, options.group, options.item);
	},
	removeSelection({ commit }, options) {
		commit(types.REMOVE_SELECTION, options.group, options.lookupKey, options.item);
	},
	clearSelections({ commit }, group) {
		commit(types.CLEAR_SELECTIONS, group);
	},
	showEditModal ({ commit }) {
		commit(types.TOGGLE_EDIT_MODAL, true);
	},
	closeEditModal ({ commit }) {
		commit(types.TOGGLE_EDIT_MODAL, false);
		commit(types.SET_EDIT_TELESCOPE, {});
	},
	selectTab ({ commit }, tab) {
		commit(types.SELECT_TAB, tab);
	},
	selectEyepiece ({ commit }, eyepiece) {
		commit(types.SELECT_EYEPIECE, eyepiece);
	},
	deselectEyepiece ({ commit }, eyepiece) {
		commit(types.DESELECT_EYEPIECE, eyepiece);
	},
	setSelectedEyepieces ({ commit }, eyepieceIDs) {
		commit(types.SET_EYEPIECE_SELECTIONS, eyepieceIDs);
	},
	selectTelescope ({ commit }, telescope) {
		commit(types.SET_SELECTED_TELESCOPE, telescope);
	},
	setTelescopes ({ commit }, telescopes) {
		commit(types.SET_TELESCOPES, telescopes);
	},
	removeTelescope ({ commit }, telescope) {
		commit(types.REMOVE_TELESCOPE, telescope);
	},
	addTelescope ({ commit }, telescope) {
		commit(types.ADD_TELESCOPE, telescope);
	},
	updateTelescope({ commit }, telescope) {
		commit(types.UPDATE_TELESCOPE, telescope);
	},
	saveTelescope({ commit, state }, telescope) {
		if (state.telescopeToEdit) {
			commit(types.UPDATE_TELESCOPE, telescope);
		} else {
			commit(types.ADD_TELESCOPE, telescope);
		}

		commit(types.SET_EDIT_TELESCOPE, null);
	}
};
