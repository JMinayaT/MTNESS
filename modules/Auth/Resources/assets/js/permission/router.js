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
        name: 'role.create'
    },
    {
        path: '/app/roles/edit/:id',
        component: PermissionEdit,
        name: 'role.edit'
    },
    {
        path: '/app/roles/view/:id',
        component: PermissionView,
        name: 'role.view'
    },
];