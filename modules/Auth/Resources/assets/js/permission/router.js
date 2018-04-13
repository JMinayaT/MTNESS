import PermissionList from './components/List.vue';
import PermissionCreate from './components/Create.vue';
import PermissionEdit from './components/Edit.vue';
import PermissionView from './components/View.vue';

export default [{
        path: '/app/roles',
        component: PermissionList,
        name: 'roles'
    },
    {
        path: '/app/roles/create',
        component: PermissionCreate,
        name: 'roles.create'
    },
    {
        path: '/app/roles/edit',
        component: PermissionEdit,
        name: 'roles.edit'
    },
    {
        path: '/app/roles/view',
        component: PermissionView,
        name: 'roles.view'
    },
];