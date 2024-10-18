<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="z-50 border-b border-gray-200 p-4">
            <nav aria-label="Breadcrumb" class="flex justify-start">
                <ol class="flex overflow-hidden rounded-lg border border-gray-200 text-gray-600">
                    <li class="flex items-center">
                        <a href="#" class="flex h-10 items-center gap-1.5 bg-gray-100 px-4 transition hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>

                            <span class="ms-1.5 text-xs font-medium"> Home </span>
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="p-6">
            <a href="#" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
                <span class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>

                <div class="sm:flex sm:justify-between sm:gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 sm:text-xl">Dokumen & Surat Perjanjian</h3>

                        <p class="mt-1 text-xs font-medium text-gray-600">{{ form.field.type }}</p>
                    </div>

                    <div class="hidden sm:block sm:shrink-0">
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
        </div>
    </div>
</template>

<script>
import { DataTable } from 'simple-datatables'

export default {
    data() {
        return {
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

        printDoc() {
            window.open('profile/profile-document/agreement?id=' + this.form.field.id + '_blank')
        },

        formatTanggal(tanggal) {
            const bulanIndo = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            const dateObj = new Date(tanggal);
            const hari = dateObj.getDate();
            const bulan = bulanIndo[dateObj.getMonth()];
            const tahun = dateObj.getFullYear();

            return `${hari} ${bulan} ${tahun}`;
        }
    },
}
</script>
