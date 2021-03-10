<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todo List</div>

                    <div class="card-body">
                        <div class="form-control">
                            <input type="checkbox" name="show" id="show" v-model="isShow">
                        </div>
                        <div class="data" v-show="isShow">
                            Test thu data 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                isShow: true,
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style>

</style>