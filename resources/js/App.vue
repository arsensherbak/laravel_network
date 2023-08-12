<template>
    <div class="flex h-screen">
        <div class="w-1/3 bg-gray-200 p-4">
            <router-link :to="{name: 'index'}" class="text-3xl font-bold block mb-4">Index</router-link>
            <router-link v-if="token" :to="{name: 'page'}" class="text-3xl font-bold block mb-4">Page</router-link>
            <router-link v-if="!token" :to="{name: 'registr'}" class="text-3xl font-bold block mb-4">Registration
            </router-link>
            <router-link v-if="!token" :to="{name: 'log'}" class="text-3xl font-bold block mb-4">Login</router-link>
            <router-link v-if="token" :to="{name: 'personal'}" class="text-3xl font-bold block mb-4">Personal
            </router-link>
            <a v-if="token" @click.prevent="logout" href="#" class="text-3xl font-bold block mb-4">Выход</a>
        </div>
        <div class="w-2/3 p-4">
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
            console.log(this.token)
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
