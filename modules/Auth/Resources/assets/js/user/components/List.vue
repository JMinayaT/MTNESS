<template>
    <div>
        <page :title="$trans('user.users')" icon="fas fa-users"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-list"></i> {{ $trans('user.list-users') }}</div>

                    <div><router-link :to="{ name: 'user.create'}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> {{ $trans('user.new') }}</router-link>

                    <button type="button" class="btn btn-danger btn-sm" @click.prevent="deleteSelectUsers()">
                        <i class="fas fa-trash-alt"></i> {{ $trans('user.remove') }}
                    </button></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <datatable ref="datatable" url="/api/user" 
                            :columns="columns"
                            :actions="actions"
                            :options="setOptions()"
                            >
                        </datatable> 
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import toastr from 'toastr'
    export default {
        created() {
            if( !(this.$auth.can('browse_users') && this.$auth.can('read_users')) ){
                this.$router.push({ path: '/app/403'})
            }
        },
        data () {
            return  {
                columns: [
                    { data: "id",       title: '#' },
                    { data: "username", title: this.$trans('users.user') },
                    { data: "email",    title: this.$trans('users.email') },
                    { data: "roles",    title: this.$trans('users.role') },
                    { data: "active",   title: this.$trans('users.status') },
                    { data: "actions",  title: this.$trans('users.actions') },
                 ],
                actions: [
                    { name:'view', title: '', class:'btn btn-primary btn-sm', icon:'fas fa-eye', method:'viewUser', permission: this.$auth.can('read_users')},
                    { name:'edit', title: '', class:'btn btn-warning btn-sm', icon:'fas fa-pencil-alt', method:'editUser', permission: this.$auth.can('edit_users')},
                    { name:'delete', title: '', class:'btn btn-danger btn-sm', icon:'fas fa-trash-alt', method:'deleteUser', permission: this.$auth.can('delete_users')},
                ],
                arraySelect: {}
            }
        },
        methods: {
            setOptions: function() {
                let vm = this
                return {
                    "columnDefs": [ 
                        {
                            "render": function ( data, type, row ) {
                                console.log(row[5])
                                if (row[5] == 'true') {
                                    return `<span class="badge badge-success">${vm.$trans('user.activated')}</span>`
                                }
                                else {
                                    return `<span class="badge badge-danger">${vm.$trans('user.disabled')}</span>`
                                }
                            },
                            "targets": 5
                        },
                         {
                            "targets": 4,
                            "render": function(data, type, row) {
                                let arr = JSON.parse(row[4])
                                return (arr.length == 0) ? vm.$trans('user.n-results') : arr[0].name.replace("_", " ")
                            }
                        }
                       
                    ]
                }
            },
            viewUser: function(data) {
                this.$router.push({ name: 'user.view', params: { id: data.id }})          
            },

            editUser: function(data) {
                this.$router.push({ name: 'user.edit', params: { id: data.id }})          
            },

            deleteUser: function(data) {
                let url = '/api/user/' + data.id
                let vm = this
                $.confirm({
                    title: vm.$trans('user.confirm-d'),
                    content: '',
                    type: 'red',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-red',
                            text: vm.$trans('user.remove'),
                            action: function(){
                                axios.delete(url).then(response =>{
                                    toastr.success(vm.$trans('user.removed'))
                                    vm.$refs.datatable.deleteDtRow(data.dtp)        
                                });
                            }
                        },
                        cancel:{
                            text: vm.$trans('user.cancel'),
                            action: function(){}
                        },
                    }
                });
            },

            deleteSelectUsers: function() {
                let ids = this.$refs.datatable.arraySelect()
                if (ids.length == 0) {
                    return toastr.error(this.$trans('user.not-select-d-msj'))
                }
                let url = '/api/delete-many/user'
                let vm = this
                $.confirm({
                    title: vm.$trans('user.confirm-dm'),
                    content: '',
                    type: 'red',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-red',
                            text: vm.$trans('user.remove'),
                            action: function(){
                                axios.post(url, {'ids':ids}).then(response =>{
                                    vm.$refs.datatable.deleteDtSelect()
                                    toastr.success(vm.$trans('user.removed'));
                                });
                            }
                        },
                        cancel:{
                            text: vm.$trans('user.cancel'),
                            action: function(){}
                        },
                    }
                });
            },    
        }
    }
</script>