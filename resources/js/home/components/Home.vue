<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="flex flex-col gap-4 p-6">
            <template v-if="loading">
                <div role="status" class="max-w animate-pulse rounded border border-gray-200 p-4 shadow dark:border-gray-700 md:p-6">
                    <div class="mb-4 h-2.5 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                    <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                    <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                    <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                    <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                    <div class="h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                    <span class="sr-only">Loading...</span>
                </div>
            </template>
            <template v-else>
                <template v-if="user.role === 0">
                    <div class="mt-2 grid grid-cols-12 gap-4">
                        <div class="col-span-6 sm:col-span-3">
                            <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                                <span class="rounded-full bg-sky-100 p-3 text-sky-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </span>

                                <div>
                                    <p class="text-1xl sm:text-2xl font-medium text-gray-900">{{ dashboard.books }}</p>

                                    <p class="text-sm text-gray-500">Total Buku</p>
                                </div>
                            </article>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                                <span class="rounded-full bg-emerald-100 p-3 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                                        />
                                    </svg>
                                </span>

                                <div>
                                    <p class="text-1xl sm:text-2xl font-medium text-gray-900">{{ dashboard.client }}</p>

                                    <p class="text-sm text-gray-500">Total Client</p>
                                </div>
                            </article>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                                <span class="rounded-full bg-orange-100 p-3 text-orange-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 sm:size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                    </svg>
                                </span>

                                <div>
                                    <p class="text-1xl sm:text-2xl font-medium text-gray-900">{{ dashboard.supplier }}</p>

                                    <p class="text-sm text-gray-500">Total Supplier</p>
                                </div>
                            </article>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                                <span class="rounded-full bg-amber-100 p-3 text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 sm:size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                    </svg>
                                </span>

                                <div>
                                    <p class="text-1xl sm:text-2xl font-medium text-gray-900">{{ dashboard.distributor }}</p>

                                    <p class="text-sm text-gray-500">Total Distributor</p>
                                </div>
                            </article>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <a href="#" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
                        <div class="sm:flex sm:justify-between sm:gap-4">
                            <div class="flex justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 sm:text-xl">Manual Guide Daftar & Upload Buku Supplier</h3>
                                </div>

                                <div>
                                    <div class="block sm:hidden md:hidden lg:hidden">
                                        <button class="inline-block rounded border border-sky-500 bg-sky-500 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-sky-500 focus:outline-none focus:ring active:text-sky-500" @click="downloadFile">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden sm:block">
                                <button class="group relative inline-flex items-center overflow-hidden rounded bg-sky-500 px-8 py-2 text-white focus:outline-none focus:ring active:bg-sky-500" @click="downloadFile">
                                    <span class="absolute -start-full transition-all group-hover:start-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </span>

                                    <span class="text-sm font-semibold transition-all group-hover:ms-4"> Download Guide </span>
                                </button>
                            </div>
                        </div>
                    </a>

                    <a href="#" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
                        <span class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>

                        <div class="sm:flex sm:justify-between sm:gap-4">
                            <div class="flex justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 sm:text-xl">Dokumen & Surat Perjanjian</h3>

                                    <p class="mt-1 text-xs font-medium text-gray-600">{{ form.field.type }}</p>
                                </div>

                                <div>
                                    <div class="block sm:hidden md:hidden lg:hidden">
                                        <button class="inline-block rounded border border-emerald-500 bg-emerald-500 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-500 focus:outline-none focus:ring active:text-emerald-500" @click="printDoc">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden sm:block">
                                <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-2 text-white focus:outline-none focus:ring active:bg-emerald-500" @click="printDoc">
                                    <span class="absolute -start-full transition-all group-hover:start-4">
                                        <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
                                            />
                                        </svg>
                                    </span>

                                    <span class="text-sm font-semibold transition-all group-hover:ms-4"> Print Dokumen </span>
                                </button>
                            </div>
                        </div>

                        <div class="mt-2">
                            <p class="text-pretty text-sm text-gray-500">{{ form.field.name }}</p>
                        </div>

                        <dl class="mt-2 flex gap-4 sm:gap-6">
                            <div class="flex flex-col-reverse">
                                <dd class="text-xs text-gray-500">{{ form.field.created_at }}</dd>
                                <dt class="text-sm font-medium text-gray-600">Terdaftar pada</dt>
                            </div>
                        </dl>
                    </a>
                </template>
            </template>
        </div>
    </div>
</template>

<script>
import { DataTable } from 'simple-datatables'

export default {
    data() {
        return {
            loading: true,
            user: {},

            form: {
                field: {
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    country: '',
                    province: '',
                    regency: '',
                    district: '',
                    subdistrict: '',
                    postal_code: '',
                    address: '',
                    telephone: '',
                    handphone: '',
                    director: '',
                    position: '',
                    handphone_director: '',
                    person_in_charge: '',
                    handphone_person_in_charge: '',
                    npwp: '',
                    account_bank: '',
                    bank: '',
                    account_name: '',
                    bank_city: '',
                    type: '',
                    created_at: '',
                },
            },

            dashboard: {
                books: 0,
                client: 0,
                supplier: 0,
                distributor: 0,
            },
        }
    },

    mounted() {
        this.getData()
        this.userinfo()
        this.getDashboard()
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

        getData() {
            let loader = this.$loading.show()
            window.axios
                .get('/profile/profile-company')
                .then((response) => {
                    let profile = response.data.data

                    this.form.field.id = profile[0].id
                    this.form.field.name = profile[0].name
                    this.form.field.email = profile[0].email
                    this.form.field.country = profile[0].country
                    this.form.field.province = profile[0].province
                    this.form.field.regency = profile[0].regency
                    this.form.field.district = profile[0].district
                    this.form.field.subdistrict = profile[0].subdistrict
                    this.form.field.postal_code = profile[0].postal_code
                    this.form.field.address = profile[0].address
                    this.form.field.handphone = profile[0].handphone
                    this.form.field.director = profile[0].director
                    this.form.field.position = profile[0].position
                    this.form.field.handphone_director = profile[0].handphone_director
                    this.form.field.person_in_charge = profile[0].pic
                    this.form.field.handphone_person_in_charge = profile[0].handphone_pic
                    this.form.field.created_at = this.formatTanggal(profile[0].created_at)
                    this.form.field.type = profile[0].type == '1' ? 'Supplier' : profile[0].type == '2' ? 'Distributor' : 'Distributor & Supplier'

                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },

        getDashboard() {
            let loader = this.$loading.show()
            window.axios
                .get('/profile/profile-company/x0y0z0', {
                    params: {
                        param: 'dashboard-admin',
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.dashboard.books = response.data.books
                    this.dashboard.client = response.data.client
                    this.dashboard.supplier = response.data.supplier
                    this.dashboard.distributor = response.data.distributor
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        printDoc() {
            window.open('profile/profile-document/agreement?id=' + this.form.field.id + '_blank')
        },

        formatTanggal(tanggal) {
            const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']

            const dateObj = new Date(tanggal)
            const hari = dateObj.getDate()
            const bulan = bulanIndo[dateObj.getMonth()]
            const tahun = dateObj.getFullYear()

            return `${hari} ${bulan} ${tahun}`
        },

        async downloadFile() {
            await window
                .axios({
                    url: '/profile/profile-document/download-file',
                    method: 'GET',
                    responseType: 'blob',
                    params: {
                        file: this.form.field.id,
                    },
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'Manual Guide Daftar & Upload Buku Supplier.pdf')
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
        },
    },
}
</script>
