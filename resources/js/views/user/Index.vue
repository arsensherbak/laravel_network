<template>
    <div class="w-3/4 mx-auto">
        <div v-if="users">
            <h2 class="mb-2 pb-2 mt-4 border-b border-gray-400 font-bold">Users</h2>
               <User v-for="user in users" class="mb-4 pb-8 border-b border-gray-300" :user="user"></User>
        </div>
    </div>
</template>
<script>
import User from "../../components/User.vue";
export default {
    name: "Index",
    data() {
        return {
            users: [],
            user_id: null
        }
    },
    mounted() {
        this.gerUsers()
    },
    components:{
      User
    },
    methods: {
        gerUsers() {
            axios.get('/api/users')
                .then(res => {
                    this.users = res.data.data
                    console.log(this.users)
                })
                .catch(e => {
                    console.log(e)
                })
        }
    }
}
</script>
<style scoped>

</style>
