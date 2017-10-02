import Vue from 'vue';

const endpoint = '/api/telescope';
const validateTelescopeIdentity = telescope => {
	if (!telescope.id || typeof telescope.id === 'undefined') {
		throw new Error('Invalid telescope. Missing ID');
	}
}

export default {
	add(telescope) {
		return Vue.http.post(endpoint, telescope);
	},
	remove(telescope) {
		validateTelescopeIdentity(telescope);
		return Vue.http.delete(`${endpoint}/${telescope.id}`);
	},
	update(telescope) {
		validateTelescopeIdentity(telescope);
		return Vue.http.put(`${endpoint}/${telescope.id}`, telescope);
	}
}