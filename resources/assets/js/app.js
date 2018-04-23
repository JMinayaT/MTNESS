
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
require('./admin')

window.Vue = require('vue')

import VueRouter from 'vue-router'
Vue.use(VueRouter)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.$trans = (string, args) => {
    let value = _.get(window.i18n, string)

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal)
    });
    return value
};

Vue.prototype.$auth = {
    can: (permission) => {
        if (window.auth_permissions.length == 0) {
            return false
        }
        let res = window.auth_permissions.find(element => element === permission);
        return res !== undefined ? true : false
    }
}

import Page from './components/Page.vue'
import DataTable from './components/DataTable.vue'
import NotFound from './components/errors/NotFound.vue'

Vue.component('page', Page)
Vue.component('datatable', DataTable)
Vue.component('notfound', NotFound)

const baseRoutes = [];

import PermissionRoutes from '../../../modules/Auth/Resources/assets/js/permission/router.js'
import UsersRoutes from '../../../modules/Auth/Resources/assets/js/user/router.js'
import LangRoutes from '../../../modules/System/Resources/assets/js/lang/router.js'

const ErrorsRoutes = [{
    path: '*',
    component: NotFound,
    name: 'notfound'
    },
]
const routes = baseRoutes.concat(ErrorsRoutes, PermissionRoutes, UsersRoutes, LangRoutes);
const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router
});