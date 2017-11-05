import telescopeFactoryService from '../services/telescope-factory-service';

// Initial state
export default {
	auth: {
		isAuthenticated: false,
		userName: null
	},
	selectedTab: null,
	selections: {
		eyepieces: []
	},
	selectedTelescope: telescopeFactoryService.pristineTelescope(),
	telescopeToEdit: null,
	telescopes: [],
	createEditMode: false,
	magnificationModifiers: []
};
