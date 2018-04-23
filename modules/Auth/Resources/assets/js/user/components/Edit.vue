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
                   <form method="POST" @submit.prevent="updateUser(user.id)">
                        <div class="mb-3">
                            <strong>Id: {{ user.id }}</strong>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-3 col-form-label">{{ $trans('user.user') }} <small class="text-muted">({{ $trans('user.required') }})</small></label>
                            <div class="col-sm-9">
                                <input type="text" name="username" class="form-control" :placeholder="$trans('user.username')" v-model="fillUser.username">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">{{ $trans('user.email') }} <small class="text-muted">({{ $trans('user.required') }})</small></label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" placeholder="mail@example.com" v-model="fillUser.email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{ $trans('user.name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control"  :placeholder="$trans('user.full-name')" v-model="fillUser.name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectRole" class="col-sm-3 col-form-label">{{ $trans('user.role') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="selectRole" v-model="fillUser.roles">
                                    <option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="switch switch-icon switch-pill switch-success">
                                <input type="checkbox" class="switch-input" v-model="fillUser.active" name="ActiveCheck">
                                <span class="switch-label" data-on="" data-off=""></span>
                                <span class="switch-handle"></span>
                            </label>
                            <label for="ActiveCheck">{{ $trans('user.active-user') }}</label>
                        </div>
                        
                        <a class="btn btn-primary btn-sm mb-4" data-toggle="collapse" href="#collapseNewPassword" role="button" aria-expanded="false" aria-controls="collapseNewPassword" @click="updatePassword()">
                            <i class="fas fa-key"></i> {{ $trans('user.change-pass') }}
                        </a>

                        <div class="collapse" id="collapseNewPassword">
                            <div class="form-group row">
                                <label for="pass" class="col-sm-3 col-form-label">{{ $trans('user.password') }}</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control" placeholder="**************"  v-model="fillUser.password">
                                    <small  class="form-text text-muted">
                                        {{ $trans('user.d-password') }}   
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pass" class="col-sm-3 col-form-label">{{ $trans('user.confirm-password') }}</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="**************"  v-model="fillUser.password_confirmation">
                                </div>
                            </div>   
                        </div>


                        <div class="float-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ $trans('user.save') }}</button>
                        </div>
                    </form>
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
                fillUser: {'id': '', 'name': '', 'username': '', 'email': '', 'active': '', 'roles': '',
                            'password':'', 'password_confirmation':'', 'updatePassword':false},
                roles: {},
                errors: [],
                user: {}
            }
        },
        created: function () {
            if( !(this.$auth.can('browse_users') && this.$auth.can('edit_users')) ){
                this.$router.push({ path: '/app'})
            }
            this.getUser()
            this.getRoles()
        },
        methods: {
            getUser: function() {
                let url = '/api/user/'+ this.$route.params.id
                let vm = this
                axios.get(url).then(function(response){
                    vm.user = response.data.data
                    vm.editUser()
                })
            },
            editUser: function(){
                this.fillUser.id = this.user.id
                this.fillUser.name = this.user.name
                this.fillUser.username = this.user.username
                this.fillUser.email = this.user.email
                this.fillUser.active = this.user.active
                this.fillUser.roles = (this.user.roles.length == 0 ) ? '':this.user.roles[0].id
            },
            updateUser: function(id){
                var url = '/api/user/' + id
                axios.put(url, this.fillUser).then(response => {
                    this.fillUser = {'id': '', 'name': '', 'username': '', 'email': '', 'active': '','roles': '',
                            'password':'', 'password_confirmation':'', 'updatePassword':false}
                    this.errors = []
                    toastr.success(this.$trans('user.e-success'))
                    this.$router.push({ name: 'users'})
                }).catch(error => {
                    this.errors = error.response.data.errors
                    this.showErrors()
                })
            },
            getRoles: function() {
                let url = '/api/role'
                axios.get(url).then(response => {
                    this.roles = response.data.data
                })
            },
            
        }
    }
</script>