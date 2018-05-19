import store from '../store';
import telescopeHttpService from './telescope-http-service';
import authService from './auth-service';

const addTelescope = telescope => {
	if (authService.isAuthenticated()) {
		telescopeHttpService.add(telescope).then(response => {
			let newTelescope = Object.assign(telescope, { id: response.data.data.id });
			store.dispatch('addTelescope', newTelescope);
			store.dispatch('selectTelescope', newTelescope);
		});
	} else {
		store.dispatch('addTelescope', telescope);
		store.dispatch('selectTelescope', telescope);
	}
};

const removeTelescope = telescope => {
	if (authService.isAuthenticated()) {
		telescopeHttpService.remove(telescope).then(response => {
			console.log(response);
			store.dispatch('removeTelescope', telescope);
		});
	} else {
		store.dispatch('removeTelescope', telescope);
	}
};

const updateTelescope = telescope => {
	if (authService.isAuthenticated()) {
		telescopeHttpService.update(telescope).then(response => {
			console.log(response)
			store.dispatch('updateTelescope', telescope);
		});
	} else {
		store.dispatch('updateTelescope', telescope);
	}
}

export default {
	addTelescope,
	removeTelescope,
	updateTelescope
}