<template>
    <div class="flex flex-col lg:flex-row h-screen">
        <div class="w-full lg:w-1/4 p-4 justify-center items-center">
            <router-link v-if="!token" :to="{name: 'registr'}" class="text-3xl font-bold block mb-4">Registration
            </router-link>
            <router-link v-if="!token" :to="{name: 'log'}" class="text-3xl font-bold block mb-4">Login</router-link>
            <router-link v-if="token" :to="{name: 'personal'}" class="text-3xl font-bold block mb-4">Personal</router-link>
            <router-link v-if="token" :to="{name: 'users'}" class="text-3xl font-bold block mb-4">Users</router-link>
            <router-link v-if="token" :to="{name: 'subs'}" class="text-3xl font-bold block mb-4">Мои подписки</router-link>
            <router-link v-if="token" :to="{name: 'news'}" class="text-3xl font-bold block mb-4">Новости</router-link>
            <a v-if="token" @click.prevent="logout" href="#" class="text-3xl font-bold block mb-4">Выход</a>
        </div>
        <div class="w-full lg:w-3/4 p-4">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
export default {
    name: 'App',
    data() {
        return {
            token: null
        }
    },
    mounted() {
        this.updateToken()
    },
    updated() {
        this.updateToken()
    },
    methods: {
        updateToken() {
            this.token = localStorage.getItem('x_xsrf_token');
        },
        logout() {
            axios.post('/logout')
                .then(res => {
                    localStorage.removeItem('x_xsrf_token')
                    this.token = null;
                    this.$router.push({name: 'log'})
                })
        }
    }
}
</script>

<style scoped>

</style>
