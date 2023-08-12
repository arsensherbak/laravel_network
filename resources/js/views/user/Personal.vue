<script>
export default {
    name: "Personal",
    mounted() {
        this.get()
    },
    methods: {
        get(){
            axios.get('/api/get')
                .then(res=>{
                    console.log(res);
                })
        }
    }
}
</script>

<template>
<div>12121</div>
</template>

<style scoped>

</style>
