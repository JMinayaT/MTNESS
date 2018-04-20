<template>
    <div>
        <page :title="$trans('role.roles')"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-eye"></i> {{ $trans('role.view-role') }}</div>
                    
                    <div>
                        <router-link :to="{ name: 'roles'}" class="btn btn-primary btn-sm"><i class="fas fa-list"></i> {{ $trans('role.list') }}</router-link>

                        <router-link :to="{ name: 'role.create'}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> {{ $trans('role.new') }}</router-link>

                        <router-link :to="{ name: 'role.edit', params: { id: role.id } }" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i> {{ $trans('role.edit') }}</router-link>
                    
                    
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ this.$trans('role.name') }}</h5> 
        <p class="card-text">{{role.name}}</p>
        <br>
        <h5 class="card-title">{{ this.$trans('role.permissions') }}</h5>

        <ul class="list-permissions">
             <li v-for="(item, index) in renderPermissions" :key="index" class="list-permissions-name">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"  :value="item.name" :id="item.name" disabled>
                    <label class="form-check-label" :for="item.name">
                        <strong> {{item.name}}</strong> 
                    </label>
                </div>
                <ul>
                    <li v-for="item in item.data" :key="item.id">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" :value="item.id" v-model="permissionData" :id="'perm-'+item.id" disabled>
                            <label class="form-check-label" :for="'perm-'+item.id">
                                {{item.name}}
                            </label>
                        </div>     
                    </li>
                </ul>
            </li>
        </ul> 
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return  {
                permissions: {},
                renderPermissions: {},
                permissionData: [],
                role: {},
                id: this.$route.params.id
            }
        },
        created: function () {
            if( !(this.$auth.can('browse_roles') && this.$auth.can('read_roles')) ){
                this.$router.push({ path: '/app'})
            }
            this.getPermissions()
            this.getRole()
        },
        methods: {
            getPermissions: function() {
               let url = '/api/permission'
               let vm = this
               axios.get(url).then(function(response){
                    vm.permissions = response.data.data
                    vm.renderPermissions = vm.getRenderPermissions()
                    vm.getRolesPermissions(vm.id)
               })
            },
            getRole: function() {
                let url = '/api/role/'+ this.id
                let vm = this
                axios.get(url).then(function(response){
                    vm.role = response.data.data
                })
            },
           getRolesPermissions: function(id) {
               let url = '/api/roles-permissions/'+id
               let vm = this
               axios.get(url).then(function(response){
                    vm.permissionData = response.data   
               })
           },
            getRenderPermissions: function() {
                let render = []
                let names = []
                let result = []
                let objv = { name: " ", data: [] }

                this.permissions.forEach(element => {
                    element.name = element.name.replace("_"," ")
                    render.push(element)
                })
                render.forEach(element => {
                    names.push(element.name.split(" ")[1])
                })
                Array.prototype.unique = function (a) {
                    return function () { return this.filter(a) }}(function (a, b, c) {return c.indexOf(a, b + 1) < 0
                })
                names.unique().forEach(name => {
                    let pass = []        
                    render.forEach(element => {
                        (name == element.name.split(" ")[1]) ? pass.push(element) : null
                    });
                    (pass.length <= 1 ) ? objv.data.push(pass[0]) : result.push({name:name, data:pass})  
                })
                result.unshift(objv)
                return result     
            },
        }
    }
</script>