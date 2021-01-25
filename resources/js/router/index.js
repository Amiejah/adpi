import Vue from 'vue'
import Router from 'vue-router'
import Overview from './../components/Jokes/Overview.vue';
import Edit from './../components/Jokes/Edit.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Index',
            component: Overview
        },
        {
            path: '/jokes/edit/:id',
            name: 'Edit',
            component: Edit
        },
        {
            path: '/jokes/create',
            name: 'Create',
            component: Edit,
        }
    ]
});
