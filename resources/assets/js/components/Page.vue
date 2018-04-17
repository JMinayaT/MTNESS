<template>
    <div>
        <div class="page-top d-flex justify-content-between ">
            <div class="page-title"><i :class="icon"></i> {{title}}</div>
            <nav class="d-none d-md-block" aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    {{breadcrumb}}
                </ol>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title','icon', 'breadcrumb'],
        data () {
            return  {
            }
        },
        methods: {
        }
    }
</script>