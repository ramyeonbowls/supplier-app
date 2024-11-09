<template>
    <div class="w-100 h-100 mx-auto flex flex-col overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click.prevent="submit">
                        <span class="absolute -start-full transition-all group-hover:start-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4"> Publish Buku </span>
                    </button>
                    <button class="group relative inline-flex items-center overflow-hidden rounded bg-rose-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-rose-500" @click.prevent="reject">
                        <span class="absolute -start-full transition-all group-hover:start-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4"> Reject Buku </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex flex-grow flex-col p-6">
            <div class="relative mb-4 flex gap-8">
                <details id="filterDetails" class="group [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900 transition hover:border-gray-600">
                        <span class="text-sm font-medium"> Filter Supplier </span>

                        <span class="transition group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </summary>

                    <div class="z-auto group-open:absolute group-open:start-0 group-open:top-auto group-open:mt-2">
                        <div class="w-96 rounded border border-gray-200 bg-white">
                            <header class="flex items-center justify-between p-4">
                                <span class="text-sm text-gray-700"> {{ selected.length }} Selected </span>

                                <button type="button" class="text-sm text-gray-900 underline underline-offset-4" @click="resetFilter">Reset</button>
                            </header>

                            <ul class="h-[35vh] space-y-1 overflow-scroll border-t border-gray-200 p-4">
                                <li v-for="(supplier, key) in options.supplier" :key="key">
                                    <label :for="supplier.id" class="inline-flex items-center gap-2">
                                        <input type="checkbox" :id="supplier.id" :name="supplier.id" :value="supplier.id" v-model="selected" class="size-5 rounded border-gray-300" />
                                        <span class="text-sm font-medium text-gray-700"> {{ supplier.name }} </span>
                                    </label>
                                </li>
                            </ul>

                            <footer class="flex items-center justify-end border-t border-gray-200 p-4">
                                <button type="button" class="text-sm text-gray-900 underline underline-offset-4" @click="getData">Tampilkan</button>
                            </footer>
                        </div>
                    </div>
                </details>
            </div>

            <div class="min-h-[380px] flex-grow overflow-auto">
                <table id="default-table" class="h-full border-collapse">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-50" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-slate-900/80 bg-opacity-5 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all" :style="{ width: 'auto', maxWidth: '100%' }">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-center">
                                    <div class="text-center sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Cover Buku</DialogTitle>
                                        <div class="mt-2 flex justify-center p-1">
                                            <img :src="image_url" class="rounded-lg shadow-md" :style="{ height: '450px', width: '300px' }" alt="Preview" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open = false">Close</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <TransitionRoot as="template" :show="open_sinopsis">
        <Dialog class="relative z-50" @close="open_sinopsis = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-slate-900/80 bg-opacity-5 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <InformationCircleIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-left sm:ml-4 sm:mt-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Sinopsis</DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">{{ detail_sinopsis }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open_sinopsis = false" ref="cancelButtonRef">Close</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { DataTable } from 'simple-datatables'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon, InformationCircleIcon } from '@heroicons/vue/24/outline'

let dataTable
export default {
    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationTriangleIcon,
        InformationCircleIcon,
    },

    data() {
        return {
            open: false,
            open_sinopsis: false,
            image_url: '',
            detail_sinopsis: '',

            options: {
                supplier: [],
            },

            selected: [],
            selectedRows: [],
            form: {
                submitted: false,
            },
        }
    },
    mounted() {
        this.getSupplier()

        let _row = this
        dataTable = new DataTable('#default-table', {
            sortable: true,
            data: {
                headings: [
                    { text: '#', data: 'select' },
                    { text: 'cover', data: 'path_cover' },
                    { text: 'judul', data: 'title' },
                    { text: 'file enkripsi', data: 'filename' },
                    { text: 'ukuran file', data: 'file_size' },
                    { text: 'status', data: 'status' },
                    { text: 'penulis', data: 'writer' },
                    { text: 'publisher', data: 'publisher_desc' },
                    { text: 'isbn', data: 'isbn' },
                    { text: 'eisbn', data: 'eisbn' },
                    { text: 'kategori', data: 'category_desc' },
                    { text: 'kota', data: 'city' },
                    { text: 'tahun', data: 'year' },
                    { text: 'edisi', data: 'edition' },
                    { text: 'halaman', data: 'page' },
                    { text: 'sinopsis', data: 'sinopsis' },
                    { text: 'format', data: 'size' },
                    { text: 'jilid', data: 'volume' },
                    { text: 'umur', data: 'age' },
                    { text: 'harga jual', data: 'sellprice' },
                    { text: 'harga pinjam', data: 'rentprice' },
                    { text: 'harga retail', data: 'retailprice' },
                    { text: 'tanggal upload', data: 'createdate' },
                ],
            },
            columns: [
                {
                    select: 0,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        if (data.split('|')[1] == '2') {
                            return '<input type="checkbox" class="row-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" data-row="' + data.split('|')[0] + '">'
                        }

                        return '<input type="checkbox" class="row-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 hidden" data-row="' + data.split('|')[0] + '">'
                    },
                },
                {
                    select: 1,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        return '<img src="' + data.replace('&amp;', '&') + '" class="thumbnail rounded-sm" data-image="' + data.replace('&amp;', '&') + '" alt="covers">'
                    },
                },
                {
                    select: 3,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        return (
                            '<p class="whitespace-nowrap mb-1 text-sm">' +
                            data +
                            '</p>' +
                            '<div class="flex gap-2">' +
                            '<a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" data-file="' +
                            data +
                            '">Download file enkripsi</a>' +
                            '<a href="javascript:void(0);" class="view-link inline-block rounded border border-sky-600 bg-sky-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-sky-600 focus:outline-none focus:ring active:text-sky-500" data-view="' +
                            data +
                            '">Lihat Buku</a>' +
                            '</div>'
                        )
                    },
                },
                {
                    select: 5,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        if (data == '1') {
                            return (
                                '<span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">' +
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />' +
                                '</svg>' +
                                '<p class="whitespace-nowrap text-sm">Draft</p>' +
                                '</span>'
                            )
                        }
                        if (data == '2') {
                            return (
                                '<span class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">' +
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />' +
                                '</svg>' +
                                '<p class="whitespace-nowrap text-sm">Review</p>' +
                                '</span>'
                            )
                        }
                        if (data == '3') {
                            return (
                                '<span class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">' +
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />' +
                                '</svg>' +
                                '<p class="whitespace-nowrap text-sm">Publish</p>' +
                                '</span>'
                            )
                        }
                        if (data == '4') {
                            return (
                                '<span class="inline-flex items-center justify-center rounded-full bg-lime-100 px-2.5 py-0.5 text-lime-700">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">' +
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />' +
                                '</svg>' +
                                '<p class="whitespace-nowrap text-sm">Publish pending</p>' +
                                '</span>'
                            )
                        }
                        if (data == '5') {
                            return (
                                '<span class="inline-flex items-center justify-center rounded-full bg-rose-100 px-2.5 py-0.5 text-rose-700">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">' +
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />' +
                                '</svg>' +
                                '<p class="whitespace-nowrap text-sm">Reject</p>' +
                                '</span>'
                            )
                        }
                        if (data == '6') {
                            return (
                                '<span class="inline-flex items-center justify-center rounded-full bg-stone-100 px-2.5 py-0.5 text-stone-700">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">' +
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />' +
                                '</svg>' +
                                '<p class="whitespace-nowrap text-sm">Ditarik</p>' +
                                '</span>'
                            )
                        }
                    },
                },
                {
                    select: 15,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        if (data) {
                            return '<a href="javascript:void(0)" class="detail-sinopsis whitespace-nowrap" data-sinopsis="' + encodeURIComponent(data) + '">' + data.substring(0, 10) + '...</a>'
                        }
                        return data
                    },
                },
            ],
        })
        dataTable.on('datatable.page', function (page) {
            _row.attachDownloadListeners()
        })
        dataTable.on('datatable.perpage', function (perpage) {
            _row.attachDownloadListeners()
        })
        dataTable.on('datatable.search', function (query, matched) {
            _row.attachDownloadListeners()
        })
    },

    methods: {
        hideFilter() {
            document.getElementById('filterDetails').removeAttribute('open')
        },

        resetFilter() {
            this.selected = []
        },

        getData() {
            let loader = this.$loading.show()

            this.hideFilter()

            window.axios
                .get('/transactions/approval-books', {
                    params: {
                        param: this.selected,
                    },
                })
                .then((response) => {
                    dataTable.data.data = []
                    dataTable.insert(response.data.data)

                    this.attachDownloadListeners()
                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },

        getSupplier() {
            this.options.supplier = []

            window.axios
                .get('/transactions/approval-books/x0y0z0', {
                    params: {
                        param: 'supplier-mst',
                    },
                })
                .then((response) => {
                    this.options.supplier = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        attachDownloadListeners() {
            document.querySelectorAll('.download-link').forEach((element) => {
                element.addEventListener('click', (event) => {
                    let file = event.target.closest('a').getAttribute('data-file')
                    this.downloadFile('books', file)
                })
            })

            document.querySelectorAll('.view-link').forEach((element) => {
                element.addEventListener('click', (event) => {
                    let file = event.target.closest('a').getAttribute('data-view')
                    this.viewFile(file)
                })
            })

            document.querySelectorAll('.thumbnail').forEach((element) => {
                element.addEventListener('click', (event) => {
                    let file = event.target.closest('img').getAttribute('data-image')
                    this.image_url = file
                    this.open = true
                })
            })

            document.querySelectorAll('.detail-sinopsis').forEach((element) => {
                element.addEventListener('click', (event) => {
                    let file = decodeURIComponent(event.target.closest('a').getAttribute('data-sinopsis'))
                    this.showSinopsis(file)
                })
            })

            document.querySelectorAll('.row-checkbox').forEach((element) => {
                element.addEventListener('click', (event) => {
                    let file = event.target.closest('input').getAttribute('data-row')
                    this.pushSelected(file)
                })
            })

            document.querySelectorAll('.row-checkbox').forEach((checkbox) => {
                checkbox.checked = false
            })
        },

        showImages(file) {
            this.image_url = file
            this.open = true
        },

        showSinopsis(text) {
            this.detail_sinopsis = text
            this.open_sinopsis = true
        },

        pushSelected(row) {
            this.selectedRows.push(row)
        },

        async viewFile(file) {
            try {
                // Fetch the PDF file as a Blob
                const response = await axios.get('transactions/approval-books-download/view-file', {
                    responseType: 'blob',
                    params: {
                        file: file,
                    },
                })

                // Create a URL for the Blob and open it in a new tab
                const pdfBlob = new Blob([response.data], { type: 'application/pdf' })
                const pdfUrl = URL.createObjectURL(pdfBlob)
                window.open(pdfUrl, '_blank')

                // Optionally, revoke the object URL after some time
                setTimeout(() => URL.revokeObjectURL(pdfUrl), 1000 * 60)
            } catch (error) {
                console.error('Error loading PDF:', error)
            }
        },

        async downloadFile(param, file) {
            await window
                .axios({
                    url: '/transactions/approval-books-download/download-file',
                    method: 'GET',
                    responseType: 'blob',
                    params: {
                        data: param,
                        file: file,
                    },
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', file)
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
        },

        submit() {
            if (!this.form.submitted) {
                this.form.submitted = true

                if (this.selectedRows.length > 0) {
                    let loader = this.$loading.show()
                    window.axios
                        .post('/transactions/approval-books?menu=' + this.$route.name, this.selectedRows)
                        .then((response) => {
                            this.form.submitted = false
                            this.selectedRows = []
                            this.getData()
                            loader.hide()
                            this.$notyf.success('Successfully Publish Books')
                        })
                        .catch((e) => {
                            this.form.submitted = false
                            loader.hide()

                            if (e.response && e.response.data && e.response.data.message) {
                                this.$notyf.error(e.response.data.message)
                            } else {
                                this.$notyf.error(e.message || 'An error occurred.')
                            }
                        })
                } else {
                    this.form.submitted = false
                    this.$notyf.error('Tidak ada data yang dipilih!')
                }
            }
        },

        reject() {
            if (!this.form.submitted) {
                this.form.submitted = true

                if (this.selectedRows.length > 0) {
                    let loader = this.$loading.show()
                    window.axios
                        .put('/transactions/approval-books/x0y0z?menu=' + this.$route.name, this.selectedRows)
                        .then((response) => {
                            this.form.submitted = false
                            this.selectedRows = []
                            this.getData()
                            loader.hide()
                            this.$notyf.success('Successfully Reject Books')
                        })
                        .catch((e) => {
                            this.form.submitted = false
                            loader.hide()

                            if (e.response && e.response.data && e.response.data.message) {
                                this.$notyf.error(e.response.data.message)
                            } else {
                                this.$notyf.error(e.message || 'An error occurred.')
                            }
                        })
                } else {
                    this.form.submitted = false
                    this.$notyf.error('Tidak ada data yang dipilih!')
                }
            }
        },
    },
}
</script>
