<template>
    <div>
        <router-link :to="{name: 'posts', params: {id: user.id}}">
            <div>
                <div><span class="font-bold">name</span> {{ user.name }}</div>
                <div class="mb-2"><span class="font-bold">email</span> {{ user.email }}</div>
            </div>
        </router-link>
        <div v-if="user.is_following !== true && user.auth_user !== user.id">
            <a href="#" class="border rounded p-1 bg-sky-400 rounded-lg"
               @click.prevent="followings(user)">Подписаться</a>
        </div>
        <div v-else-if="user.is_following === true && user.auth_user !== user.id">
            <a href="#" class="border rounded p-1 bg-sky-400 rounded-lg"
               @click.prevent="followings(user)">Отписаться</a>
        </div>
    </div>
</template>
<script>
export default {
    name: "User",
    props: [
        'user'
    ],
    methods:{
        followings(user){
            axios.post('/api/add_followings', {user_id: user.id})
                .then(res => {
                    user.is_following = !user.is_following;

                    console.log(res)
                })
                .catch(e => {
                    console.log(e)
                })
        },
    }
}
</script>

<style scoped>

</style>
