import store from '../store';

const isAuthenticated = () => store.getters.auth.isAuthenticated;
const isAdmin = () => store.getters.auth.isAdmin;

export default {
	isAuthenticated,
	isAdmin
};