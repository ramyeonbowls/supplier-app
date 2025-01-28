<template>
    <div class="flex flex-col gap-4 p-6">
        <!-- <a href="#" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
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
        </a> -->

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

        <div class="mt-1 grid grid-cols-12 gap-4">
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex h-full items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-emerald-100 p-3 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.publish }} <span class="text-base font-semibold text-gray-500">Buku</span></p>

                        <p class="text-sm font-semibold text-gray-500">Publish</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex h-full items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-amber-100 p-3 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.review }} <span class="text-base font-semibold text-gray-500">Buku</span></p>

                        <p class="text-sm font-semibold text-gray-500">Review</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex h-full items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-emerald-100 p-3 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.paid }} <span class="text-base font-semibold text-gray-500">PO</span></p>

                        <p class="text-sm font-semibold text-gray-500">Lunas</p>
                    </div>
                </article>
            </div>
            <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                <article class="flex h-full items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                    <span class="rounded-full bg-amber-100 p-3 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.notPaid }} <span class="text-base font-semibold text-gray-500">PO</span></p>

                        <p class="text-sm font-semibold text-gray-500">Belum Lunas</p>
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
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Total Buku Terjual</p>
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
    name: 'DashboardSupplier',

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
                publish: 0,
                review: 0,
                paid: 0,
                notPaid: 0,

                chartBooks: {
                    totals: 0,
                    total: [],
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
                        param: 'dashboard-supplier',
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.dashboard.publish = response.data.publish
                    this.dashboard.review = response.data.review
                    this.dashboard.paid = response.data.paid
                    this.dashboard.notPaid = response.data.notPaid
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
                        param: 'dashboard-supplier-1',
                        periode: this.selectedYearBooks,
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.dashboard.chartBooks.totals = response.data.totals
                    this.dashboard.chartBooks.total = response.data.total

                    this.chartBook()
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        chartBook() {
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
                        param: 'dashboard-supplier-2',
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
