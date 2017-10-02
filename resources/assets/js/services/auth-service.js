import store from '../store';

const isAuthenticated = () => store.getters.auth.isAuthenticated;

export default {
	isAuthenticated
};