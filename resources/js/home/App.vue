<template>
    <header class="z-0 flex h-12 w-full items-center justify-between bg-sidebar-color p-5 drop-shadow-sm lg:justify-end">
        <div class="menu-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-6 stroke-svg-icon-color">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </div>

        <div class="profile-icon flex gap-2">
            <div class="notif-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-6 stroke-svg-icon-color">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </div>

            <div class="user-icon relative">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-6 stroke-svg-icon-color">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                <div class="list-profile-menu absolute hidden w-[100px] -translate-x-20 translate-y-1 rounded-md bg-white p-2 text-[0.70rem] font-medium text-slate-600 drop-shadow-md">
                    <ul>
                        <li class="flex justify-start gap-2 border-t-slate-300 hover:cursor-pointer hover:text-slate-900" @click="logout">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 19 10Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>Sign out</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="sidebar hide-sidebar absolute top-0 z-50 box-border h-screen max-h-screen w-[70%] bg-sidebar-color px-5 py-5 drop-shadow-md lg:w-[20%] lg:translate-x-0">
        <div class="logo mb-10 flex w-[10rem] justify-between">
            <img src="images/logo/logo.svg" alt="logo" />
        </div>

        <div class="menus">
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

    <div class="shadow-sidebar hide-sidebar absolute top-0 z-40 flex h-screen w-full justify-end bg-slate-900/80 lg:hidden">
        <div id="button-close" class="button-close -translate-y-2 p-5 md:object-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#ffff" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </div>
    </div>

    <main class="mt-[0.05rem] box-border h-[92vh] overflow-scroll bg-slate-200 p-4 lg:ml-[20%]"><router-view></router-view></main>
    <footer></footer>
</template>

<script>
import MenuAdmin from './components/MenuAdmin.vue'
import MenuSupplier from './components/MenuSupplier.vue'
import MenuDistributor from './components/MenuDistributor.vue'
import EmptyMenu from './components/EmptyMenu.vue'

export default {
    components: {
        MenuAdmin,
        MenuSupplier,
        MenuDistributor,
        EmptyMenu,
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
            return 'EmptyMenu'
        },
        currentComponent() {
            return this.user.role === 0 ? 'MenuAdmin' : this.user.role === 1 ? 'MenuSupplier' : 'MenuDistributor'
        },
    },

    mounted() {
        const hamburgerMenu = document.querySelector('.menu-icon')
        const buttonCLose = document.getElementById('button-close')
        const shadowSidebar = document.querySelector('.shadow-sidebar')
        const sidebar = document.querySelector('.sidebar')
        const userIcon = document.querySelector('.user-icon')
        const listProfileMenu = document.querySelector('.list-profile-menu')

        window.addEventListener('resize', () => {
            const width = window.innerWidth

            if (width > 1020) {
                this.hideSidebar(shadowSidebar, sidebar)
            }
        })

        buttonCLose.addEventListener('click', () => {
            this.hideSidebar(shadowSidebar, sidebar)
        })

        hamburgerMenu.addEventListener('click', () => {
            this.showSidebar(shadowSidebar, sidebar)
        })

        userIcon.addEventListener('click', () => {
            if (listProfileMenu.classList.contains('hidden')) {
                listProfileMenu.classList.remove('hidden')
            } else {
                listProfileMenu.classList.add('hidden')
            }
        })

        document.addEventListener('DOMContentLoaded', () => {
            let loader = this.$loading.show()
            setTimeout(() => {
                loader.hide()
            }, 1000)
        })
    },

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

        async logout() {
            await window.axios.post('/logout').then((e) => {
                this.$notyf.success('Logout successful!')
                window.location = '/'
            })
        },

        hideSidebar(shadowSidebar, sidebar) {
            shadowSidebar.classList.add('hide-sidebar')
            shadowSidebar.classList.remove('show-sidebar')
            sidebar.classList.add('hide-sidebar')
            sidebar.classList.remove('show-sidebar')
        },

        showSidebar(shadowSidebar, sidebar) {
            shadowSidebar.classList.add('show-sidebar')
            shadowSidebar.classList.remove('hide-sidebar')
            sidebar.classList.add('show-sidebar')
            sidebar.classList.remove('hide-sidebar')
        },
    },
}
</script>
