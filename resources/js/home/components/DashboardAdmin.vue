<template>
    <div class="flex flex-col gap-4 p-6">
        <div class="mt-2 grid grid-cols-12 gap-4">
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
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
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.client }}</p>

                        <p class="text-sm font-semibold text-gray-500">Total Client</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-orange-100 p-3 text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 sm:size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.supplier }}</p>

                        <p class="text-sm font-semibold text-gray-500">Total Supplier</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-amber-100 p-3 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 sm:size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.distributor }}</p>

                        <p class="text-sm font-semibold text-gray-500">Total Distributor</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-sky-100 p-3 text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.publisher }}</p>

                        <p class="text-sm font-semibold text-gray-500">Total Penerbit</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-emerald-100 p-3 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.books }}</p>

                        <p class="text-sm font-semibold text-gray-500">Total Buku Publish</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-amber-100 p-3 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.review }}</p>

                        <p class="text-sm font-semibold text-gray-500">Total Buku Review</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-rose-100 p-3 text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.reject }}</p>

                        <p class="text-sm font-semibold text-gray-500">Total Buku Reject</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-slate-100 p-3 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.pending }}</p>

                        <p class="text-sm font-semibold text-gray-500">Total Buku Pending</p>
                    </div>
                </article>
            </div>
        </div>

        <div class="w-full max-w-full rounded-lg bg-white p-4 shadow dark:bg-gray-800 md:p-6">
            <div class="mb-4 flex justify-between border-b border-gray-200 pb-4 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="me-3 flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="pb-1 text-2xl font-bold leading-none text-gray-900 dark:text-white">{{ dashboard.chartBooks.totals }}</h5>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Total Upload Buku Supplier</p>
                    </div>
                </div>
                <div>
                    <select name="yearPeriodBook" id="yearPeriodBook" v-model="selectedYearBooks" @change="getDashboard1" class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                        <option v-for="year in filters.years" :key="year" :value="year">{{ year }}</option>
                    </select>
                </div>
            </div>

            <div id="books-chart"></div>
            <div class="grid grid-cols-1 items-center justify-between border-t border-gray-200 dark:border-gray-700"></div>
        </div>

        <div class="w-full max-w-full rounded-lg bg-white p-4 shadow dark:bg-gray-800 md:p-6">
            <div class="mb-4 flex justify-between border-b border-gray-200 pb-4 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="me-3 flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                fill-rule="evenodd"
                                d="M9 15a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm3.845-1.855a2.4 2.4 0 0 1 1.2-1.226 1 1 0 0 1 1.992-.026c.426.15.809.408 1.111.749a1 1 0 1 1-1.496 1.327.682.682 0 0 0-.36-.213.997.997 0 0 1-.113-.032.4.4 0 0 0-.394.074.93.93 0 0 0 .455.254 2.914 2.914 0 0 1 1.504.9c.373.433.669 1.092.464 1.823a.996.996 0 0 1-.046.129c-.226.519-.627.94-1.132 1.192a1 1 0 0 1-1.956.093 2.68 2.68 0 0 1-1.227-.798 1 1 0 1 1 1.506-1.315.682.682 0 0 0 .363.216c.038.009.075.02.111.032a.4.4 0 0 0 .395-.074.93.93 0 0 0-.455-.254 2.91 2.91 0 0 1-1.503-.9c-.375-.433-.666-1.089-.466-1.817a.994.994 0 0 1 .047-.134Zm1.884.573.003.008c-.003-.005-.003-.008-.003-.008Zm.55 2.613s-.002-.002-.003-.007a.032.032 0 0 1 .003.007ZM4 14a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm3-2a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1Zm6.5-8a1 1 0 0 1 1-1H18a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-.796l-2.341 2.049a1 1 0 0 1-1.24.06l-2.894-2.066L6.614 9.29a1 1 0 1 1-1.228-1.578l4.5-3.5a1 1 0 0 1 1.195-.025l2.856 2.04L15.34 5h-.84a1 1 0 0 1-1-1Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div>
                        <h5 class="pb-1 text-2xl font-bold leading-none text-gray-900 dark:text-white">Rp. {{ dashboard.chartPo.totals }}</h5>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Total Purchase Order</p>
                    </div>
                </div>
                <div>
                    <select name="yearPeriodPo" id="yearPeriodPo" v-model="selectedYearPo" @change="getDashboard2" class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                        <option v-for="year in filters.years" :key="year" :value="year">{{ year }}</option>
                    </select>
                </div>
            </div>

            <div id="po-chart"></div>
            <div class="grid grid-cols-1 items-center justify-between border-t border-gray-200 dark:border-gray-700"></div>
        </div>
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'

export default {
    name: 'DashboardAdmin',

    data() {
        return {
            loading: true,
            user: {},

            selectedYearBooks: new Date().getFullYear(),
            selectedYearPo: new Date().getFullYear(),
            filters: {
                years: [],
            },

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

            chartBooks: null,
            chartPo: null,
            dashboard: {
                books: 0,
                client: 0,
                supplier: 0,
                distributor: 0,
                review: 0,
                reject: 0,
                pending: 0,
                publisher: 0,

                chartBooks: {
                    totals: 0,
                    total: [],
                    publish: [],
                    review: [],
                    draft: [],
                    pending: [],
                    reject: [],
                    withdrawn: [],
                },

                chartPo: {
                    totals: 0,
                    gross: [],
                },
            },
        }
    },

    mounted() {
        this.getData()
        this.generateYears()
        this.getDashboard()
        this.getDashboard1()
        this.getDashboard2()
    },

    methods: {
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
                    this.dashboard.review = response.data.review
                    this.dashboard.reject = response.data.reject
                    this.dashboard.pending = response.data.pending
                    this.dashboard.publisher = response.data.publisher
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getDashboard1() {
            let loader = this.$loading.show()
            window.axios
                .get('/profile/profile-company/x0y0z0', {
                    params: {
                        param: 'dashboard-admin-1',
                        periode: this.selectedYearBooks,
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.dashboard.chartBooks.totals = response.data.totals
                    this.dashboard.chartBooks.total = response.data.total
                    this.dashboard.chartBooks.publish = response.data.publish
                    this.dashboard.chartBooks.review = response.data.review
                    this.dashboard.chartBooks.draft = response.data.draft
                    this.dashboard.chartBooks.pending = response.data.pending
                    this.dashboard.chartBooks.reject = response.data.reject
                    this.dashboard.chartBooks.withdrawn = response.data.withdrawn

                    this.chartUploadBook()
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        chartUploadBook() {
            if (this.chartBooks) {
                this.chartBooks.destroy()
            }

            let options = {
                colors: ['#6B7280', '#9CA3AF', '#D1D5DB', '#E5E7EB'],
                series: [
                    {
                        name: 'Total',
                        color: '#1A56DB',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.total['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.total['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.total['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.total['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.total['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.total['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.total['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.total['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.total['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.total['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.total['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.total['Desember'] },
                        ],
                    },
                    {
                        name: 'Draft',
                        color: '#E5E7EB',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.draft['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.draft['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.draft['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.draft['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.draft['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.draft['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.draft['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.draft['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.draft['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.draft['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.draft['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.draft['Desember'] },
                        ],
                    },
                    {
                        name: 'Review',
                        color: '#FDBA8C',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.review['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.review['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.review['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.review['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.review['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.review['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.review['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.review['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.review['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.review['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.review['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.review['Desember'] },
                        ],
                    },
                    {
                        name: 'Publish',
                        color: '#31C48D',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.publish['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.publish['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.publish['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.publish['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.publish['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.publish['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.publish['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.publish['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.publish['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.publish['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.publish['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.publish['Desember'] },
                        ],
                    },
                    {
                        name: 'Pending',
                        color: '#F59E0B',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.pending['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.pending['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.pending['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.pending['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.pending['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.pending['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.pending['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.pending['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.pending['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.pending['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.pending['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.pending['Desember'] },
                        ],
                    },
                    {
                        name: 'Reject',
                        color: '#EF4444',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.reject['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.reject['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.reject['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.reject['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.reject['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.reject['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.reject['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.reject['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.reject['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.reject['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.reject['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.reject['Desember'] },
                        ],
                    },
                    {
                        name: 'Withdrawn',
                        color: '#6B7280',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.withdrawn['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.withdrawn['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.withdrawn['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.withdrawn['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.withdrawn['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.withdrawn['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.withdrawn['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.withdrawn['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.withdrawn['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.withdrawn['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.withdrawn['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.withdrawn['Desember'] },
                        ],
                    },
                ],
                chart: {
                    type: 'bar',
                    height: '320px',
                    fontFamily: 'Inter, sans-serif',
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '100%',
                        borderRadiusApplication: 'end',
                        borderRadius: 2,
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    style: {
                        fontFamily: 'Inter, sans-serif',
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 1,
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 0,
                    colors: ['transparent'],
                },
                grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -14,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: false,
                },
                xaxis: {
                    floating: false,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: 'Inter, sans-serif',
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                        },
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: false,
                },
                fill: {
                    opacity: 1,
                },
            }

            if (document.getElementById('books-chart') && typeof ApexCharts !== 'undefined') {
                this.chartBooks = new ApexCharts(document.getElementById('books-chart'), options)
                this.chartBooks.render()
            }
        },

        getDashboard2() {
            let loader = this.$loading.show()
            window.axios
                .get('/profile/profile-company/x0y0z0', {
                    params: {
                        param: 'dashboard-admin-2',
                        periode: this.selectedYearPo,
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.dashboard.chartPo.totals = response.data.totals
                    this.dashboard.chartPo.gross = response.data.gross

                    this.chartPurchaseOrder()
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        chartPurchaseOrder() {
            if (this.chartPo) {
                this.chartPo.destroy()
            }

            let options = {
                grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -26,
                    },
                },
                series: [
                    {
                        name: this.selectedYearPo,
                        data: this.dashboard.chartPo.gross,
                        color: '#7E3BF2',
                    },
                ],
                chart: {
                    height: '100%',
                    maxWidth: '100%',
                    type: 'area',
                    fontFamily: 'Inter, sans-serif',
                    dropShadow: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                tooltip: {
                    enabled: true,
                    x: {
                        show: false,
                    },
                },
                legend: {
                    show: true,
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        opacityFrom: 0.55,
                        opacityTo: 0,
                        shade: '#1C64F2',
                        gradientToColors: ['#1C64F2'],
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                xaxis: {
                    floating: false,
                    categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    labels: {
                        show: true,
                        style: {
                            fontFamily: 'Inter, sans-serif',
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                        },
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: false,
                    labels: {
                        formatter: function (value) {
                            return 'Rp. ' + value
                        },
                    },
                },
            }

            if (document.getElementById('po-chart') && typeof ApexCharts !== 'undefined') {
                this.chartPo = new ApexCharts(document.getElementById('po-chart'), options)
                this.chartPo.render()
            }
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

        generateYears() {
            const currentYear = new Date().getFullYear()
            const startYear = 2024
            for (let year = currentYear; year >= startYear; year--) {
                this.filters.years.push(year)
            }
        },
    },
}
</script>
