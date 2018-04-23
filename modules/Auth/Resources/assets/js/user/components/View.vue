<template>
    <div>
        <page :title="$trans('user.users')" icon="fas fa-users"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-eye"></i> {{ $trans('user.view-user') }}</div>
                    
                    <div>
                        <router-link :to="{ name: 'users'}" class="btn btn-primary btn-sm"><i class="fas fa-list"></i> {{ $trans('user.list') }}</router-link>

                        <router-link :to="{ name: 'user.create'}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> {{ $trans('user.new') }}</router-link>

                        <router-link :to="{ name: 'user.edit', params: { id: user.id } }" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i> {{ $trans('user.edit') }}</router-link>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Id</th>
                                    <td>{{ user.id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ $trans('user.name') }}</th>
                                    <td>{{ user.name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ $trans('user.user') }}</th>
                                    <td>{{ user.username }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ $trans('user.email') }}</th>
                                    <td>{{ user.email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ $trans('user.role') }}</th>
                                    <td>{{ getRoleName(user.roles) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ $trans('user.status') }}</th>
                                    <td><span v-bind:class="{ 'badge badge-success': user.active == 1,'badge badge-danger': user.active == 0 }">{{ toActive(user.active)}}</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ $trans('user.created') }}</th>
                                    <td>{{ user.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return  {
                user: {},
            }
        },
        created: function () {
            if( !(this.$auth.can('browse_users') && this.$auth.can('read_users')) ){
                this.$router.push({ path: '/app/403'})
            }
            this.getUser()
        },
        methods: {
            getUser: function() {
                let url = '/api/user/'+ this.$route.params.id
                let vm = this
                axios.get(url).then(function(response){
                    vm.user = response.data.data
                })
            },
            getRoleName: function(data){
                return (data && data.length == 0) ? this.$trans('user.n-results') : (data)?data[0].name.replace("_", " "):""
            },
            toActive: function(value){
                if(value == true){
                    return this.$trans('user.activated')
                }
                else {
                    return this.$trans('user.disabled')
                }
            }
           
        }
    }
</script>