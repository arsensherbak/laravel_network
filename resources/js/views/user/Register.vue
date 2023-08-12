<template>
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 shadow-md rounded-md w-96">
            <h2 class="text-2xl font-semibold mb-4">Регистрация</h2>
            <form @submit.prevent="register">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Имя:</label>
                    <input type="text" id="name" v-model="name" required class="mt-1 p-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" v-model="email" required class="mt-1 p-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Пароль:</label>
                    <input type="password" id="password" v-model="password" required
                           class="mt-1 p-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Подтверждение
                        пароля:</label>
                    <input type="password" id="confirmPassword" v-model="password_confirmation" required
                           class="mt-1 p-2 w-full border rounded-md">
                </div>
                <button type="submit" class="w-full bg-blue-500 p-2 rounded-md hover:bg-blue-600">
                    Зарегистрироваться
                </button>
                <p v-if="errorMessage" class="text-red-500 mt-4">{{ errorMessage }}</p>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    name: "Register",
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errorMessage: ''
        };
    },
    methods: {
        register() {
            if (this.password !== this.password_confirmation) {
                this.errorMessage = 'Пароли не совпадают';
                return;
            }

            if (!this.validateEmail(this.email)) {
                this.errorMessage = 'Некорректный email';
                return;
            }

            if (this.password.length < 6) {
                this.errorMessage = 'Пароль должен быть не менее 6 символов';
                return;
            }

            // Здесь вы можете добавить дополнительную валидацию и отправку запроса на сервер

            this.errorMessage = ''; // Очищаем сообщение об ошибке
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }).then(response => {
                    localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN'])
                    this.$router.push({name: 'index'})
                }).catch(err=>{
                    console.log(err.response)
                })
            });
        },
        validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },

    }
}
</script>

<style scoped>

</style>
