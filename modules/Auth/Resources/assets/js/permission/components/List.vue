<template>
    <div>
        <page title="Roles"></page>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <datatable url="/api/role" 
                            :columns="columns" 
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

        },
        data () {
            return  {
                columns: [
                    { data: "name", title: this.$trans('role.name') },
                    { data: "actions",  title: this.$trans('role.actions') },
                 ],
           
                arraySelect: {}
            }
        },
        methods: {
        }
    }
</script>