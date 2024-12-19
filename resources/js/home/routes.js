const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "404" */ './components/404.vue'),
        meta: { roles: [0, 1, 2] },
    },
    {
        path: '/forbidden',
        name: 'forbidden',
        component: () => import(/* webpackChunkName: "403" */ './components/403.vue'),
        meta: { roles: [0, 1, 2] },
    },
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './components/Home.vue'),
        meta: { roles: [0, 1] },
    },
    {
        path: '/profile',
        name: 'profile',
        component: () => import(/* webpackChunkName: "profile" */ './components/Profile.vue'),
        meta: { roles: [1] },
    },
    {
        path: '/encrypt-book',
        name: 'encrypt_book',
        component: () => import(/* webpackChunkName: "encrypt_book" */ './components/EncryptBooks.vue'),
        meta: { roles: [1] },
    },
    {
        path: '/category-book',
        name: 'category_book',
        component: () => import(/* webpackChunkName: "category_book" */ './components/CategoryBooks.vue'),
        meta: { roles: [1] },
    },
    {
        path: '/encrypt-file',
        name: 'encrypt_file',
        component: () => import(/* webpackChunkName: "encrypt_file" */ './components/EncryptFiles.vue'),
        meta: { roles: [0] },
    },
    {
        path: '/approval-book',
        name: 'approval_book',
        component: () => import(/* webpackChunkName: "approval_book" */ './components/ApprovalBooks.vue'),
        meta: { roles: [0] },
    },
    {
        path: '/data-supplier',
        name: 'data_supplier',
        component: () => import(/* webpackChunkName: "data_supplier" */ './components/ReportSupplier.vue'),
        meta: { roles: [0] },
    },
    {
        path: '/data-distributor',
        name: 'data_distributor',
        component: () => import(/* webpackChunkName: "data_distributor" */ './components/ReportDistributor.vue'),
        meta: { roles: [0] },
    },
    {
        path: '/approval-client',
        name: 'approval_client',
        component: () => import(/* webpackChunkName: "approval_client" */ './components/ApprovalClient.vue'),
        meta: { roles: [0] },
    },
    {
        path: '/report-po',
        name: 'report_po',
        component: () => import(/* webpackChunkName: "report_po" */ './components/ReportPO.vue'),
        meta: { roles: [1] },
    },
    {
        path: '/data-po',
        name: 'data_po',
        component: () => import(/* webpackChunkName: "data_po" */ './components/UploadPO.vue'),
        meta: { roles: [0] },
    },
    {
        path: '/data-paid-off',
        name: 'data_paid_off',
        component: () => import(/* webpackChunkName: "data_paid_off" */ './components/UploadPaidOff.vue'),
        meta: { roles: [0] },
    },
]

export default routes
