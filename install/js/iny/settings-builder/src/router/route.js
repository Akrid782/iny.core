import { createRouter, createWebHashHistory } from 'ui.vue3.router';
import routes from './routes';

export default createRouter({
    history: createWebHashHistory(),
    routes,
});
