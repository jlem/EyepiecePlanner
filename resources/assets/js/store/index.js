import Vue from 'vue';
import Vuex from 'vuex';
import * as types from './mutation-types';

const defaultTelescope = {
	aperture: null,
	focal_length: null,
	max_eyepiece_size: null
}

// Initial state
const state = {
	selectedTab: null,
	selectedEyepieceIDs: [],
	selectedTelescope: defaultTelescope,
	telescopes: []
};

// Getters
const getters = {
	selectedEyepieceIDs: state => state.selectedEyepieceIDs,
	selectedTelescope: state => Object.assign({}, state.selectedTelescope),
	selectedTab: state => Object.assign({}, state.selectedTab),
	telescopes: state => state.telescopes
};

// Actions
const actions = {
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

		storedTelescope.focal_length = telescope.focal_length;
		storedTelescope.aperture = telescope.aperture;
		storedTelescope.max_eyepiece_size = telescope.max_eyepiece_size;
	}
};

export default new Vuex.Store({
	state,
	getters,
	actions,
	mutations,
	strict: process.env.NODE_ENV !== 'production'
});