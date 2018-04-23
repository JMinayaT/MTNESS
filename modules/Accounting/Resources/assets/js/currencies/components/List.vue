<template>
    <div>
        <page :title="$trans('currency.currencies')" icon="far fa-money-bill-alt"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><i class="fas fa-sliders-h"></i> {{ $trans('currency.currencies_title') }}</div>

                    <div>
                        <button type="button" class="btn btn-success btn-sm" @click.prevent="addCurrency()">
                            <i class="fas fa-plus"></i> {{ $trans('currency.add') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3 col-md-6">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Moneda por defecto</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>Choose...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <table class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>code</th>
                                <th>name</th>
                                <th>symbol</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        

        <!-- MODAL ADD CURRENCY-->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <i class="fas fa-plus"></i> {{ $trans('currency.add_currency') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <select class="custom-select" v-model="selectedCurrency">
                            <option selected>......</option>
                            <option v-for="currency in jsonCurrencies" :value="currency"> 
                                {{currency.code}} - {{currency.name}}</option>
                        </select>
                        <table class=" mt-2 table table-bordered" v-if="!isEmpty(selectedCurrency)">
                            <tr>
                                <th>code</th>
                                <td>{{selectedCurrency.code}}</td>
                            </tr>
                            <tr>
                                <th>name</th>
                                <td>{{selectedCurrency.name}}</td>
                            </tr>
                            <tr>
                                <th>symbol</th>
                                <td>{{selectedCurrency.symbol}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import toastr from 'toastr'
import commonCurrency from './../../../data/Common-Currency.json';

    export default {
        created() {
            if( !(this.$auth.can('browse_roles') && this.$auth.can('read_roles')) ){
                this.$router.push({ path: '/app'})
            }
            console.log(this.jsonCurrencies)
            
        },
        data () {
            return  {
                jsonCurrencies: commonCurrency,
                selectedCurrency: []
            }
        },
        methods: {
            addCurrency(){
               $('#addModal').modal('toggle')
               console.log(this.selectedCurrency.length)
            },
            fillJsonSelect() {

            },
            isEmpty(object){
                return _.isEmpty(object)
            }
        },
        
    }
</script>