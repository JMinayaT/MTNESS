<template>
    <div>
        <page :title="$trans('role.roles')" icon="fas fa-lock"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-list"></i> {{ $trans('role.list-roles') }}</div>

                    <div><router-link :to="{ name: 'role.create'}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> {{ $trans('role.new') }}</router-link>

                    <button type="button" class="btn btn-danger btn-sm" @click.prevent="deleteSelectRoles()">
                        <i class="fas fa-trash-alt"></i> {{ $trans('role.remove') }}
                    </button></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <datatable ref="datatable" url="/api/role" 
                            :columns="columns"
                            :actions="actions"
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
            if( !(this.$auth.can('browse_roles') && this.$auth.can('read_roles')) ){
                this.$router.push({ path: '/app'})
            }
        },
        data () {
            return  {
                columns: [
                    { data: "id", title: '#', style:'width: 4%;'},
                    { data: "name", title: this.$trans('role.name') },
                    { data: "actions",  title: this.$trans('role.actions') },
                 ],
                actions: [
                    { name:'view', title: '', class:'btn btn-primary btn-sm', icon:'fas fa-eye', method:'viewRole',permission: this.$auth.can('read_roles')},
                    { name:'edit', title: '', class:'btn btn-warning btn-sm', icon:'fas fa-pencil-alt', method:'editRole',permission: this.$auth.can('edit_roles')},
                    { name:'delete', title: '', class:'btn btn-danger btn-sm', icon:'fas fa-trash-alt', method:'deleteRole',permission: this.$auth.can('delete_roles')},
                ],
                arraySelect: {}
            }
        },
        methods: {
            viewRole: function(data) {
                this.$router.push({ name: 'role.view', params: { id: data.id }})          
            },

            editRole: function(data) {
                this.$router.push({ name: 'role.edit', params: { id: data.id }})          
            },

            deleteRole: function(data) {
                let url = '/api/role/' + data.id
                let vm = this
                $.confirm({
                    title: vm.$trans('role.confirm-d'),
                    content: '',
                    type: 'red',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-red',
                            text: vm.$trans('role.remove'),
                            action: function(){
                                axios.delete(url).then(response =>{
                                    toastr.success(vm.$trans('role.removed'))
                                    vm.$refs.datatable.deleteDtRow(data.dtp)        
                                });
                            }
                        },
                        cancel:{
                            text: vm.$trans('role.cancel'),
                            action: function(){}
                        },
                    }
                });
            },

            deleteSelectRoles: function() {
                let ids = this.$refs.datatable.arraySelect()
                if (ids.length == 0) {
                    return toastr.error(this.$trans('role.not-select-d-msj'))
                }
                let url = '/api/delete-many/role'
                let vm = this
                $.confirm({
                    title: vm.$trans('role.confirm-dm'),
                    content: '',
                    type: 'red',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-red',
                            text: vm.$trans('role.remove'),
                            action: function(){
                                axios.post(url, {'ids':ids}).then(response =>{
                                    vm.$refs.datatable.deleteDtSelect()
                                    toastr.success(vm.$trans('role.removed'));
                                });
                            }
                        },
                        cancel:{
                            text: vm.$trans('role.cancel'),
                            action: function(){}
                        },
                    }
                });
            },    
        }
    }
</script>