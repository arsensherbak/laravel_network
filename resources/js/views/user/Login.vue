<template>
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 shadow-md rounded-md w-96">
            <h2 class="text-2xl font-semibold mb-4">Вход</h2>
            <form @submit.prevent="login">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" v-model="email" required class="mt-1 p-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Пароль:</label>
                    <input type="password" id="password" v-model="password" required
                           class="mt-1 p-2 w-full border rounded-md">
                </div>
                <button type="submit" class="w-full bg-blue-500 p-2 rounded-md hover:bg-blue-600">Войти
                </button>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    name: "Login",
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {email: this.email, password: this.password})
                    .then(response => {
                       localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN'])
                        this.$router.push({name: 'personal'})

                    }).catch(err => {
                        console.log(err.response)
                })
            });
        }
    }
}
</script>

