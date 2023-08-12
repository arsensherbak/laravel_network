Vue.prototype.$eventHub = new Vue(); // Глобальное хранилище событий

new Vue({
    render: h => h(App),
}).$mount('#app');
