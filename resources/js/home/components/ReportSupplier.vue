<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="z-50 border-b border-gray-200 p-4">
            <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click.prevent="exportTpl">
                <span class="absolute -start-full transition-all group-hover:start-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </span>

                <span class="text-sm font-medium transition-all group-hover:ms-4"> Download Excel </span>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-4 flex items-center justify-between">
                <div class="relative">
                    <input type="text" id="search" v-model="searchQuery" placeholder="Search for..." class="w-full rounded-md border-gray-200 py-2 pe-10 shadow-sm sm:text-sm" />
                </div>

                <div class="flex w-[20rem] items-center justify-end gap-2">
                    <label for="HeadlineAct" class="block text-sm font-medium text-gray-900"> Rows per page : </label>
                    <select v-model="rowsPerPage" class="w-1/4 rounded-md border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm">
                        <option v-for="option in perPageOptions" :key="option" :value="option">
                            {{ option }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="rounded-lg border border-gray-300">
                    <div class="overflow-x-auto rounded-t-lg">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-slate-300 text-left">
                                <tr>
                                    <th v-for="(header, index) in headers" :key="index" @click="sortBy(header)" class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">
                                        {{ header.label }}
                                        <template v-if="sortKey === header.key">
                                            <span v-if="sortAsc" class="inline-flex items-center">
                                                <svg class="-me-0.5 ms-1 size-3.5 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500" d="m7 15 5 5 5-5"></path>
                                                    <path class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500" d="m7 9 5-5 5 5"></path>
                                                </svg>
                                            </span>
                                            <span v-else class="inline-flex items-center">
                                                <svg class="-me-0.5 ms-1 size-3.5 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500" d="m7 15 5 5 5-5"></path>
                                                    <path class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500" d="m7 9 5-5 5 5"></path>
                                                </svg>
                                            </span>
                                        </template>
                                    </th>
                                    <th class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">Dokumen & Surat Perjanjian</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                <template v-if="paginatedData.length > 0">
                                    <tr v-for="row in paginatedData" :key="row.Id" class="whitespace-nowrap even:bg-gray-50 hover:bg-gray-100">
                                        <td v-for="header in headers" :key="header.key" class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                            {{ row[header.key] }}
                                        </td>
                                        <td class="flex justify-center whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                            <a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" @click="printDoc(row.Id)">Print Document</a>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr class="even:bg-gray-50 hover:bg-gray-100">
                                        <td :colspan="headers.length" class="border-b border-gray-200 px-4 py-2 text-center">No Data to Show !</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-2">
                        <div>
                            <p class="text-sm text-gray-600">Showing {{ startEntry }} to {{ endEntry }} of {{ filteredData.length }} entries</p>
                        </div>
                        <ol class="flex justify-end gap-1 text-xs font-medium">
                            <li>
                                <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 disabled:opacity-50 rtl:rotate-180">
                                    <span class="sr-only">Prev Page</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </li>

                            <li v-if="currentPage > 3">
                                <button @click="goToPage(1)" class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900">1</button>
                            </li>

                            <li v-if="currentPage > 4">
                                <span class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900">...</span>
                            </li>

                            <li v-for="page in pagesToShow" :key="page">
                                <button @click="goToPage(page)" :class="page === currentPage ? 'block size-8 rounded border-blue-600 bg-blue-600 text-center leading-8 text-white' : 'block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900'">
                                    {{ page }}
                                </button>
                            </li>

                            <li v-if="currentPage < totalPages - 3">
                                <span class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900">...</span>
                            </li>

                            <li v-if="currentPage < totalPages - 2">
                                <button @click="goToPage(totalPages)" class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900">{{ totalPages }}</button>
                            </li>

                            <li>
                                <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 disabled:opacity-50 rtl:rotate-180">
                                    <span class="sr-only">Next Page</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            headers: [
                { label: 'ID', key: 'Id' },
                { label: 'Nama', key: 'SupplierName' },
                { label: 'Email', key: 'Email' },
                { label: 'Negara', key: 'Country' },
                { label: 'Provinsi', key: 'Province' },
                { label: 'Kabupaten/Kota', key: 'Regency' },
                { label: 'Kecamatan', key: 'District' },
                { label: 'Kelurahan', key: 'SubDistrict' },
                { label: 'Alamat', key: 'Address' },
                { label: 'No. Hp', key: 'SupplierPhone' },
                { label: 'Directur', key: 'DirectorName' },
                { label: 'No. Hp Directur', key: 'DirectorPhone' },
                { label: 'PIC', key: 'PersonInChargeName' },
                { label: 'No. Hp PIC', key: 'PersonInChargePhone' },
            ],
            data: [],
            searchQuery: '',
            rowsPerPage: 10,
            currentPage: 1,
            sortKey: '',
            sortAsc: true,
            perPageOptions: [10, 15, 20, 25, 30],
        }
    },

    mounted() {
        this.getData()
    },

    computed: {
        filteredData() {
            let data = this.data

            if (this.searchQuery) {
                data = data.filter((person) => Object.values(person).some((value) => String(value).toLowerCase().includes(this.searchQuery.toLowerCase())))
            }

            if (this.sortKey) {
                data.sort((a, b) => {
                    const result = a[this.sortKey] > b[this.sortKey] ? 1 : -1
                    return this.sortAsc ? result : -result
                })
            }

            return data
        },

        paginatedData() {
            const start = (this.currentPage - 1) * this.rowsPerPage
            const end = start + this.rowsPerPage
            return this.filteredData.slice(start, end)
        },

        totalPages() {
            return Math.ceil(this.filteredData.length / this.rowsPerPage) || 1
        },

        pagesToShow() {
            const range = []
            for (let i = Math.max(1, this.currentPage - 1); i <= Math.min(this.totalPages, this.currentPage + 1); i++) {
                range.push(i)
            }
            return range
        },

        startEntry() {
            return (this.currentPage - 1) * this.rowsPerPage + 1
        },

        endEntry() {
            return Math.min(this.currentPage * this.rowsPerPage, this.filteredData.length)
        },
    },

    methods: {
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page
            }
        },

        getData() {
            this.data = []

            let loader = this.$loading.show()
            window.axios
                .get('/report/supplier-report')
                .then((response) => {
                    this.data = response.data.data
                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },

        sortBy(header) {
            if (this.sortKey === header.key) {
                this.sortAsc = !this.sortAsc
            } else {
                this.sortKey = header.key
                this.sortAsc = true
            }
        },

        async exportTpl() {
            await window
                .axios({
                    url: '/report/supplier-report-excel/export-tpl',
                    method: 'GET',
                    responseType: 'blob',
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'report_supplier.xlsx')
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
        },

        printDoc(id) {
            window.open('profile/profile-document/agreement?id=' + id + '_blank')
        },
    },

    watch: {
        rowsPerPage() {
            this.currentPage = 1
            this.currentPage = Math.min(this.currentPage, this.totalPages)
        },

        searchQuery() {
            this.currentPage = 1
        },

        filteredData() {
            this.currentPage = Math.min(this.currentPage, this.totalPages)
        },
    },
}
</script>
