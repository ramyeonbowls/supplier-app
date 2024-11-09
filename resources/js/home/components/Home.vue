<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="flex flex-col gap-4 p-6">
            <template v-if="loading">
                <div role="status" class="max-w animate-pulse rounded border border-gray-200 p-4 shadow dark:border-gray-700 md:p-6">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 mb-4"></div>
                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                    <span class="sr-only">Loading...</span>
                </div>
            </template>
            <template v-else>
                <template v-if="user.role === 0">
                    <a href="#" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
                        <div class="sm:flex sm:justify-between sm:gap-4">
                            <div class="flex justify-between gap-4">
                                <div class="text-center">
                                    <h3 class="text-lg font-bold text-gray-900 sm:text-xl">Welcome Admin Genesia</h3>
                                </div>
                            </div>
                        </div>
                    </a>
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
        }
    },

    mounted() {
        this.getData()
        this.userinfo()
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
