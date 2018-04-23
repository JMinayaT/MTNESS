<template>
    <div>
        <page :title="$trans('lang.languages')" icon="fas fa-language"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-cogs"></i> {{ $trans('lang.set_lang') }}</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">{{ $trans('lang.languages') }}</th>
                                    <th scope="col">{{ $trans('lang.code') }}</th>
                                    <th scope="col">{{ $trans('lang.default') }}</th>
                                    <th scope="col">{{ $trans('lang.set_lang') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lang in langs">
                                     <td>
                                        <img :src="lang.image" :alt="lang.code" class="mr-2" height="30" width="50">
                                        {{ $trans('lang.'+lang.code) }}
                                    </td>
                                    <td style="text-transform: uppercase;">{{ lang.code }}</td>
                                    <td>
                                        <label class="switch switch-icon switch-success">
                                            <input type="radio" class="switch-input" name="langDefault"  v-model="defaultLang" :value="lang.code">
                                            <span class="switch-label" data-on="" data-off=""></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-icon switch-success">
                                            <input type="radio" class="switch-input" name="langUserCheck" v-model="userLang" :value="lang.code">
                                            <span class="switch-label" data-on="" data-off=""></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                    <div class="float-right">
                        <button type="button" @click="update" class="btn btn-success"><i class="fas fa-save"></i> {{ $trans('lang.save') }}</button>
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
            if( !(this.$auth.can('browse_lang') && this.$auth.can('read_lang')) ){
                this.$router.push({ path: '/app/403'})
            }
            this.getLangs()
            this.getDefaultLang()
            this.getUserLang()
        },
        data () {
            return  {
                langs: [],
                defaultLang: '',
                userLang: ''
            }
        },
        methods: {
            getLangs: function() {
                let url = '/api/lang'
                let vm = this
                axios.get(url).then(response =>{
                    vm.langs = response.data.data
                });
            },
            getDefaultLang: function() {
                var url = '/api/default-lang'
                axios.get(url).then(response =>{
                    this.defaultLang =  response.data
                });
            },
             getUserLang: function(){
                let url = '/api/user-lang'
                let vm = this
                axios.get(url).then(response =>{
                    vm.userLang =  response.data
                })
            },
            update() {
                this.updateDefaultLang()
                this.updateUserLang()
                toastr.success(this.$trans('lang.success'))           
                setTimeout('document.location.reload()',2000); 
            },
            updateDefaultLang: function() {
                var url = '/api/default-lang'
                axios.post(url, {'lang':this.defaultLang}).then(response =>{
                   
                })
            },
            updateUserLang: function() {
                var url = '/api/user-lang'
                var lang = '';
                for (var i = 0; i < this.langs.length; i++) {
                    if (this.langs[i].code === this.userLang) {
                        lang =  this.langs[i];
                    }
                }
                axios.post(url, lang).then(response =>{
                })
            }
        }
    }
</script>