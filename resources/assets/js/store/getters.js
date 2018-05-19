export default {
	auth: state => state.auth,
	isCreateEditMode: state => state.createEditMode,
	selectedTelescope: state => state.selectedTelescope,
	telescopeToEdit: state => Object.assign({}, state.telescopeToEdit),
	selectedTab: state => Object.assign({}, state.selectedTab),
	telescopes: state => state.telescopes,
	getSelections: (state, getters) => group => state.selections[group],
	getAllSelections: state => state.selections
};
