<template>
    <div class="container-fluid">
        <div class="errors">
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <h1 class="ops">Ooups !</h1>
                    <p>Pagina no encontrada</p>
                    <p>Error 404</p>
                    <router-link :to="{ path: '/app/dashboard'}" class="btn btn-primary" replace>Ir al inicio</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return  {
               
            }
        },
        methods: {
        }
    }
</script>