const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './components/UploadBooks.vue'),
    },
]

export default routes
