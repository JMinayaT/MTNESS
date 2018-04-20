import UserList from './components/List.vue';
import UserCreate from './components/Create.vue';
import UserEdit from './components/Edit.vue';
import UserView from './components/View.vue';

export default [{
        path: '/app/users',
        component: UserList,
        name: 'users'
    },
    {
        path: '/app/users/create',
        component: UserCreate,
        name: 'user.create'
    },
    {
        path: '/app/users/edit/:id',
        component: UserEdit,
        name: 'user.edit'
    },
    {
        path: '/app/users/view/:id',
        component: UserView,
        name: 'user.view'
    },
];