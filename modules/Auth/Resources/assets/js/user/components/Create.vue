<template>
    <div>
        <page :title="$trans('user.users')" icon="fas fa-users"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-plus"></i> {{ $trans('user.new-user') }}</div>
                    
                    <router-link :to="{ name: 'users'}" class="btn btn-primary btn-sm"><i class="fas fa-list"></i> {{ $trans('user.list') }}</router-link>
                </div>
                <div class="card-body">
                    <form method="POST" @submit.prevent="createUser">

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{ $trans('user.user') }} <small class="text-muted">({{ $trans('user.required') }})</small></label>
                            <div class="col-sm-9">
                                <input type="text" name="username" class="form-control"  :placeholder="$trans('user.username')" v-model="newUser.username"  v-bind:class="{ 'is-invalid': hasError('username') }" autofocus>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">{{ $trans('user.email') }} <small class="text-muted">({{ $trans('user.required') }})</small></label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" placeholder="mail@example.com" v-model="newUser.email" v-bind:class="{ 'is-invalid': hasError('email')}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{ $trans('user.name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control"  :placeholder="$trans('user.full-name')" v-model="newUser.name"  v-bind:class="{ 'is-invalid': hasError('name') }">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">{{ $trans('user.password') }} <small class="text-muted">({{ $trans('user.required') }})</small></label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" placeholder="**************" v-model="newUser.password" v-bind:class="{ 'is-invalid': hasError('password') }">
                                <small  class="form-text text-muted">
                                    {{ $trans('user.d-password') }}                    
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-3 col-form-label">{{ $trans('user.confirm-password') }}</label>
                            <div class="col-sm-9">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="**************" v-model="newUser.password_confirmation" v-bind:class="{ 'is-invalid': hasError('password')}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="selectRole" class="col-sm-3 col-form-label">{{ $trans('user.role') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="selectRole" v-model="newUser.roles">
                                    <option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="switch switch-icon switch-pill switch-success">
                            <input type="checkbox" class="switch-input" v-model="newUser.active" name="ActiveCheck">
                            <span class="switch-label" data-on="" data-off=""></span>
                            <span class="switch-handle"></span>
                        </label>
                        <label for="ActiveCheck">{{ $trans('user.active-user') }}</label>
                        </div>

                        <div class="float-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ $trans('user.create') }}</button>
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
                newUser:  {'name': '','username': '','email': '','password': '','password_confirmation': '','roles':'', 'active':false},
                roles: {},
                errors: [],
                newActive: false

            }
        },
        created: function () {
            if( !(this.$auth.can('browse_users') && this.$auth.can('add_users')) ){
                this.$router.push({ path: '/app/403'})
            }
            this.getRoles()
        },
        methods: {
            createUser: function(){
                var url = '/api/user';
                axios.post(url, this.newUser).then(response =>{
                    this.newUser =  {'name': '','username': '','email': '','password': '','password_confirmation': '', 'active':false}
                    toastr.success(this.$trans('user.c-success'))
                    this.$router.push({ name: 'users'})
                }).catch(error => {
                    this.errors = error.response.data.errors
                    this.showErrors()
                    
                });
            },
            getRoles: function() {
                let url = '/api/role'
                axios.get(url).then(response => {
                    this.roles = response.data.data
                })
            },
            showErrors: function()  {
                for (var error in this.errors) {
                    if (!this.errors.hasOwnProperty(error)) continue;
                    var obj = this.errors[error];
                    for (var prop in obj) {
                        if(!obj.hasOwnProperty(prop)) continue;
                        toastr.error(obj[prop])
                    }
                }
            },
            hasError: function($name) {
                if(! this.errors) {
                    return false
                }
                return this.errors.hasOwnProperty($name)
            }
            
        }
    }
</script>