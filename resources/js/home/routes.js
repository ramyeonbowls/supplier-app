const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './components/ExampleComponent.vue'),
    },
]

export default routes
