import {createRouter, createWebHistory} from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/index',
            component: () => import('../views/Index.vue'),
            name: 'index'
        },
        {
            path: '/page',
            component: () => import('../views/Page.vue'),
            name: 'page'
        },
        {
            path: '/user/login',
            component: () => import('../views/user/Login.vue'),
            name: 'log'
        },
        {
            path: '/user/registration',
            component: () => import('../views/user/Register.vue'),
            name: 'registr'
        },
        {
            path: '/personal',
            component: () => import('../views/user/Personal.vue'),
            name: 'personal'
        },
    ]
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token')

    if (!token) {
        if (to.name === 'registr' || to.name === 'log') {
            return next()
        } else {
            return next({
                name: "log"
            })
        }
    }
    if (to.name === 'registr' || to.name === 'log' && token) {
        return next({
            name: "index"
        })
    }
    next()
})
export default router
