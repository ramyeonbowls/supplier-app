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
        path: '/profile',
        name: 'profile',
        component: () => import(/* webpackChunkName: "profile" */ './components/Profile.vue'),
    },
    {
        path: '/encrypt-book',
        name: 'encrypt_book',
        component: () => import(/* webpackChunkName: "encrypt_book" */ './components/EncryptBooks.vue'),
    },
    {
        path: '/category-book',
        name: 'category_book',
        component: () => import(/* webpackChunkName: "category_book" */ './components/CategoryBooks.vue'),
    },
    {
        path: '/encrypt-file',
        name: 'encrypt_file',
        component: () => import(/* webpackChunkName: "encrypt_file" */ './components/EncryptFiles.vue'),
    },
]

export default routes
