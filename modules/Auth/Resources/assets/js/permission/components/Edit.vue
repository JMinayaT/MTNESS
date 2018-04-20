<template>
    <div>
        <page :title="$trans('role.roles')" icon="fas fa-lock"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-pencil-alt"></i> {{ $trans('role.edit-role') }}</div>               
                    <div>
                        <router-link :to="{ name: 'roles'}" class="btn btn-primary btn-sm"><i class="fas fa-list"></i> {{ $trans('role.list') }}</router-link>

                        <router-link :to="{ name: 'role.create'}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> {{ $trans('role.new') }}</router-link>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST"  @submit.prevent="updateRole(id)">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ $trans('role.name') }} <small class="text-muted">({{ $trans('role.required') }})</small></label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control"  :placeholder="$trans('role.name')" v-model="fillRole.name">
                </div>
            </div>
            <br>
            <h5 class="card-title">{{ this.$trans('role.permissions') }}</h5>
            <ul class="list-permissions">
                <li v-for="(item, index) in renderPermissions" :key="index" class="list-permissions-name">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"  :value="item.name" v-model="selected" :id="item.name" @change="selectAll(item.name,index)">
                        <label class="form-check-label" :for="item.name">
                           <strong> {{item.name}}</strong> 
                        </label>
                    </div>
                    <ul>
                        <li v-for="item in item.data" :key="item.id">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" :value="item.id" v-model="fillRole.permissions" :id="'perm-'+item.id">
                                <label class="form-check-label" :for="'perm-'+item.id">
                                    {{item.name}}
                                </label>
                            </div>     
                        </li>
                    </ul>
                </li>
            </ul> 

            <div class="float-right">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ $trans('role.save') }}</button>
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
                fillRole: {id:'', name: '', permissions: []},
                permissions: {},
                renderPermissions: {},
                selected: [],
                errors: [],
                role: {},
                id: this.$route.params.id
            }
        },
        created: function () {
            if( !(this.$auth.can('browse_roles') && this.$auth.can('edit_roles')) ){
                this.$router.push({ path: '/app'})
            }
            this.getRole()
            this.getPermissions()
           
        },
        methods: {
            getRole: function() {
                let url = '/api/role/'+ this.id
                let vm = this
                axios.get(url).then(function(response){
                    vm.role = response.data.data
                    vm.fillRole.id = vm.role.id
                    vm.fillRole.name = vm.role.name
                    
                })
            },
            updateRole: function(id) {
                var url = '/api/role/'+id;
                axios.put(url, this.fillRole).then(response => {
                    this.newRole = {id:'',name: '', permissions: []}
                    toastr.success(this.$trans('role.e-success'))
                    this.$router.push({ name: 'roles'})
                }).catch(error => {
                    this.errors = error.response.data.errors
                    this.showErrors() 
                });
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
            getPermissions: function() {
               let url = '/api/permission'
               let vm = this
               axios.get(url).then(function(response){
                    vm.permissions = response.data.data
                    vm.renderPermissions = vm.getRenderPermissions()
                    vm.getRolesPermissions(vm.fillRole.id)
               })
           },
           getRolesPermissions: function(id) {
               let url = '/api/roles-permissions/'+id
               let vm = this
               axios.get(url).then(function(response){
                    vm.fillRole.permissions = response.data
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
            selectAll: function(name,index) {
                let ids = []
                let select = false
                this.renderPermissions[index].data.forEach(element =>{
                    ids.push(element.id)
                })
                this.selected.find(element =>{
                     select = (element === name) ? true: false                    
                })
                // agregar
                if(select){
                    ids.forEach(id => {
                        let s = true
                        this.fillRole.permissions.find(element => {
                            if ( id == element) {
                                s = false
                            }
                        })
                        if(s) {
                            this.fillRole.permissions.push(id)
                        }
                    })
                }
                else {
                    // quitar
                    ids.forEach(id => {
                        this.fillRole.permissions.find(element =>{
                            if (id == element) {
                                let index = this.fillRole.permissions.indexOf(id)
                                if (index > -1) {
                                    this.fillRole.permissions.splice(index,1)
                                }
                            }
                        }) 
                    })
                }
            }
        }
    }
</script>