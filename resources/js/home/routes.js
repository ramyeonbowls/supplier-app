const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "404" */ './components/404.vue'),
    },
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './components/Home.vue'),
    },
    {
        path: '/encrypt-book',
        name: 'encrypt_book',
        component: () => import(/* webpackChunkName: "encrypt_book" */ './components/EncryptBooks.vue'),
    },
]

export default routes
