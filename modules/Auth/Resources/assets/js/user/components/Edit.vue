<template>
    <div>
        <page :title="$trans('user.users')" icon="fas fa-users"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-pencil-alt"></i> {{ $trans('user.edit-user') }}</div>
                    <div>
                        <router-link :to="{ name: 'users'}" class="btn btn-primary btn-sm"><i class="fas fa-list"></i> {{ $trans('user.list') }}</router-link>

                        <router-link :to="{ name: 'user.create'}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> {{ $trans('user.new') }}</router-link>
                    </div>
                </div>
                <div class="card-body">
                   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import toastr from 'toastr'

    export default {
        data () {
            return  {
            }
        },
        created: function () {
            if( !(this.$auth.can('browse_users') && this.$auth.can('edit_users')) ){
                this.$router.push({ path: '/app'})
            }
        },
        methods: {
            
        }
    }
</script>