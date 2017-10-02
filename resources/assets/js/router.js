import Vue from 'vue';
import VueRouter from 'vue-router';
import EyepieceList from './pages/EyepieceList.vue';
import EyepieceDetails from './pages/EyepieceDetails.vue';
import TelescopeList from './pages/TelescopeList.vue';
import TelescopeDetails from './pages/TelescopeDetails.vue';

Vue.use(VueRouter);

const routes = [
	{ path: '/', component: EyepieceList },
	{ path: '/eyepiece/:id', component: EyepieceDetails, props: true }
];

export default new VueRouter({
	routes
});
