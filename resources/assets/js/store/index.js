import Vue from 'vue';
import Vuex from 'vuex';
import * as types from './mutation-types';

const defaultTelescope = {
	aperture: null,
	focal_length: null,
	focal_ratio: null,
	max_eyepiece_size: null
}

// Initial state
const state = {
	selectedTab: null,
	selectedEyepieceIDs: [],
	selections: {
		eyepieces: []
	},
	selectedTelescope: defaultTelescope,
	telescopes: [],
	createEditMode: false,
	magnificationModifiers: []
};

// Getters
const getters = {
	isCreateEditMode: state => state.createEditMode,
	selectedEyepieceIDs: state => state.selectedEyepieceIDs,
	selectedTelescope: state => Object.assign({}, state.selectedTelescope),
	selectedTab: state => Object.assign({}, state.selectedTab),
	telescopes: state => state.telescopes,
	magnificationModifiers: state => state.magnificationModifiers,
	getSelections: (state, getters) => group => state.selections[group],
	getAllSelections: state => state.selections
};

// Actions
const actions = {
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
	setMagnificationModifiers ({ commit }, modifiers) {
		commit(types.SET_MAGNIFICATION_MODIFIERS, modifiers);
	},
	showEditModal ({ commit }) {
		commit(types.TOGGLE_EDIT_MODAL, true)
	},
	closeEditModal ({ commit }) {
		commit(types.TOGGLE_EDIT_MODAL, false)
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
		let mutation = state.telescopes.find(t => t.name === telescope.name) ? types.UPDATE_TELESCOPE : types.ADD_TELESCOPE;
		commit(mutation, telescope);
	}
};

// Mutations
const mutations = {
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
	[types.SET_MAGNIFICATION_MODIFIERS] (state, modifiers) {
		state.magnificationModifiers = modifiers;
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
		state.selectedEyepieceIDs = eyepieceIDs;
	},
	[types.SET_SELECTED_TELESCOPE] (state, telescope) {
		state.selectedTelescope = telescope;
	},
	[types.SET_TELESCOPES] (state, telescopes) {
		state.telescopes = telescopes;
	},
	[types.ADD_TELESCOPE] (state, telescope) {
		let storedTelescope = state.telescopes.find(t => t.name === telescope.name);

		if (storedTelescope) {
			throw new Error('Telescope name must be unique');
		}

		state.telescopes.push(telescope);
	},
	[types.REMOVE_TELESCOPE] (state, telescope) {
		let index = state.telescopes.findIndex(t => t.name === telescope.name);
		if (index > -1) {
			state.telescopes.splice(index, 1);
		}
	},
	[types.UPDATE_TELESCOPE] (state, telescope) {
		let storedTelescope = state.telescopes.find(t => t.name === telescope.name);

		if (!storedTelescope) {
			throw new Error('Telescope does not exist');
		}

		// Need to individual property value assignment so as to keep data binding intact.
		storedTelescope.focal_length = telescope.focal_length;
		storedTelescope.focal_ratio =  telescope.focal_ratio;
		storedTelescope.aperture = telescope.aperture;
		storedTelescope.max_eyepiece_size = telescope.max_eyepiece_size;
	},
	[types.TOGGLE_EDIT_MODAL] (state, status) {
		state.createEditMode = status;
	}
};

export default new Vuex.Store({
	state,
	getters,
	actions,
	mutations,
	strict: process.env.NODE_ENV !== 'production'
});