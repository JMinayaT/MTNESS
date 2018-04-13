<template>
    <table class="table table-striped table-bordered table-hover" width="100%">
        <thead>
            <tr>
                <th v-if="select"></th>
                <th v-for="column in renderColumns" v-html="title(column)" :key='column.data'></th>
                <th v-if="isActions">{{ actionsName }}</th>
            </tr>
        </thead>

        <tfoot v-show="footer">
            <tr>
                <th v-if="select"></th>
                <th v-for="column in renderColumns"  v-html="title(column)" :key='column.data'></th>
                <th v-if="isActions">{{ actionsName }}</th>
            </tr>
        </tfoot>
    
        <tbody>
            <tr v-for="(item, index) in array" :key="index">
                <td v-if="select">
                    <span :value="item['id']"></span>
                </td>
                <td v-for="column in renderColumns" :key='column.data'>{{item[column.data]}}</td>
                <td :id="'dt-'+index" v-if="isActions">
                    <span>
                        <button v-for="action in actions" v-if="action.permission" :class="action.class" :key="action.name" 
                            @click="callMethodsActions(action.method, item, 'dt-'+index)">
                            <i :class="action.icon"></i> {{action.title}}
                        </button>
                    </span>
                </td>
            </tr>
        </tbody>

    </table>
</template>

<script>
    require('datatables.net-bs4')
    require('datatables.net-select')

    export default { 
        data() {
            return {
                dataTable: {},
                actionsName: '',
                array: {}
            }
        },
        props: {
            footer: { default: false },
            columns: { type: Array },
            isActions: { default: true },
            actions: {},
            options: {
                type: Object,
                default: function () {
                    return { columnDefs: [] }
                }
            },

            url: { default: '' },
            select: {default: true}
        },
        computed: {
            parameters: function() {
                let selectAct= {}
                if(this.select){
                    selectAct = {
                        select: {
                            style:    'multi',
                            selector: 'td:first-child'
                        }
                    }
               
                    this.options.columnDefs.push({ 
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0 
                    })
                }
                return $.extend(true, {                        
                        "aaSorting": [],
                     },
                     { "language": {
                             "url": "/api/lang/datatable"
                        }
                     },
                     this.options,
                     selectAct
                );                        
            },
            renderColumns: function() {
                if(this.isActions) {
                    if(this.columns[this.columns.length - 1]) {
                            this.actionsName = this.columns[this.columns.length - 1]['title']
                            this.columns.pop()
                            return this.columns
                        }
                }
                return this.columns
            }
        },
        created: function() {
            this.getData();
        },
        updated: function() {
            this.dataTable = $(this.$el).DataTable(this.parameters);
        },
        methods: {
            title: function(column) {
                return column.title || this.titleCase(column.data);
            },
            titleCase: function(str) {
                return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
            },
            getData: function() {
                axios.get(this.url).then(response => {
                    console.log(response.data.data)
                    this.array = response.data.data
                })       
            },
            callMethodsActions(method,data,row) {
                this.$parent[method]([data,row])
            },
            arraySelect: function() {
                let ids = [];
                let select = this.dataTable.rows( { selected: true } ).data().toArray()
                select.forEach(function(value){
                    ids.push(value[0].slice(13,-9))
                })
                return ids
            },
            deselect: function() {
                this.dataTable.rows( { selected: true } ).deselect()
            },
            deleteDtRow(row) {
                let id = '#'+row
                this.dataTable.row($(id).parents('tr')).remove().draw()
            },
            deleteDtSelect(){
                this.dataTable.rows('.selected').remove().draw()
            }
        },
    }
</script>
