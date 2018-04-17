<template>
    <div>
        <page :title="$trans('role.roles')" icon="fas fa-lock"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-list"></i> {{ $trans('role.list-roles') }}</div>

                    <router-link :to="{ name: 'role.create'}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> {{ $trans('role.new') }}</router-link>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <datatable url="/api/role" 
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
    export default {
        created() {
            if(! this.$auth.can('browse_roles')){
                this.$router.push({ path: '/app'})
            }
        },
        data () {
            return  {
                columns: [
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
        }
    }
</script>