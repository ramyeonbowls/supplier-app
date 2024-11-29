const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "404" */ './components/404.vue'),
    },
    {
        path: '/pendaftaran-supplier',
        name: 'pendaftaran_supplier',
        component: () => import(/* webpackChunkName: "pendaftaran_supplier" */ './components/RegisterSupplier.vue'),
    },
    {
        path: '/pendaftaran-client',
        name: 'pendaftaran_client',
        component: () => import(/* webpackChunkName: "pendaftaran_client" */ './components/RegisterClient.vue'),
    },
    {
        path: '/pendaftaran-distributor',
        name: 'pendaftaran_distributor',
        component: () => import(/* webpackChunkName: "pendaftaran_distributor" */ './components/RegisterDistributor.vue'),
    },
]

export default routes
