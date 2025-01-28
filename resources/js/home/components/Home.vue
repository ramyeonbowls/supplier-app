<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="dashboard">
            <template v-if="loading">
                <component :is="defaultComponent">
                    <template v-slot></template>
                </component>
            </template>
            <template v-else>
                <component :is="currentComponent">
                    <template v-slot></template>
                </component>
            </template>
        </div>
    </div>
</template>

<script>
import DashboardLoad from './DashboardLoad.vue'
import DashboardAdmin from './DashboardAdmin.vue'
import DashboardSupplier from './DashboardSupplier.vue'
import DashboardDistributor from './DashboardDistributor.vue'

export default {
    components: {
        DashboardLoad,
        DashboardAdmin,
        DashboardSupplier,
        DashboardDistributor,
    },

    data() {
        return {
            loading: true,
            user: {},
        }
    },

    created() {
        this.userinfo()
    },

    computed: {
        defaultComponent() {
            return 'DashboardLoad'
        },
        currentComponent() {
            return this.user.role === 0 ? 'DashboardAdmin' : this.user.role === 1 ? 'DashboardSupplier' : 'DashboardDistributor'
        },
    },

    mounted() {},

    methods: {
        userinfo() {
            this.user = {}

            window.axios
                .get('/userinfo')
                .then((response) => {
                    this.user = response.data
                    this.loading = false
                })
                .catch((e) => {
                    console.error(e)
                })
        },
    },
}
</script>
