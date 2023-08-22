<template>
    <div class="w-3/4 mx-auto">
        <div v-if="users">
            <User v-for="user in users" class="mb-4 pb-8 border-b border-gray-300" :user="user"></User>
        </div>
    </div>
</template>
<script>
import User from "../../components/User.vue";

export default {
    name: "MySubscriptions",
    components: {User},
    data() {
        return {
            users: null
        }
    },
    mounted() {
        this.getSubscriptions()
    },
    methods: {
        getSubscriptions() {
            axios.get('/api/get_users')
                .then(res => {
                    console.log(res.data.data)
                    this.users = res.data.data
                })
                .catch(e => {
                    console.log(e)
                })
        }
    }
}
</script>
