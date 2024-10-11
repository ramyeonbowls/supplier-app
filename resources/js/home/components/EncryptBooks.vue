<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <template v-if="form.data">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click="encrypt">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Upload Enkripsi Buku </span>
                        </button>
                    </template>
                    <template v-else-if="form.encrypt">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click.prevent="submit">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Proses </span>
                        </button>
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-red-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click="cancelEncrypt">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Batalkan </span>
                        </button>
                    </template>
                    <template v-else-if="form.update">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click.prevent="submitUpdate">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Proses </span>
                        </button>
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-red-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click="cancelUpdate">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Kembali </span>
                        </button>
                    </template>
                    <template v-else-if="form.upload">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click.prevent="submitUploadExcel">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Proses </span>
                        </button>
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-red-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click="cancelUpload">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Kembali </span>
                        </button>
                    </template>
                    <template v-else-if="form.review">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click.prevent="submitReview">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Proses </span>
                        </button>
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-red-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click="cancelReview">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Kembali </span>
                        </button>
                    </template>
                </div>
                <div class="bread-nav"></div>
            </div>
        </div>
        <div class="p-6">
            <div class="tabs-container">
                <div class="tabs flex w-48 gap-2">
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.data ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Data</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.encrypt ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Enkripsi Buku</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.update ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Kelengkapan Informasi</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.upload ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Upload</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.review ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Review</button>
                </div>

                <div class="tab-content mt-4">
                    <div class="tab-panel" :class="form.data ? '' : 'hidden'">
                        <table id="default-table">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="tab-panel" :class="form.encrypt ? '' : 'hidden'">
                        <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                            <form @submit.prevent="handleSubmit($event, submit)">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
                                    <div class="h-32 font-[sans-serif]">
                                        <label class="mb-2 block text-base font-semibold text-red-500">UPLOAD FILE ZIP PDF BUKU UNTUK DI ENKRIPSI</label>
                                        <input type="file" class="w-full cursor-pointer rounded border bg-white text-sm font-semibold text-gray-400 file:mr-4 file:cursor-pointer file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-gray-500 file:hover:bg-gray-200" aria-describedby="file_pdf" ref="file_pdf" id="file_pdf" name="file_pdf" @change="onChangePdf" accept=".zip" />
                                        <p class="mt-2 text-xs text-gray-400">.ZIP yang di Izinkan.</p>
                                    </div>
                                    <div class="h-32 font-[sans-serif]" :class="form.field.file_pdf ? '' : 'hidden'">
                                        <label class="mb-2 block text-base font-semibold text-red-500">UPLOAD FILE ZIP COVER</label>
                                        <input type="file" class="w-full cursor-pointer rounded border bg-white text-sm font-semibold text-gray-400 file:mr-4 file:cursor-pointer file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-gray-500 file:hover:bg-gray-200" aria-describedby="file_cover" ref="file_cover" id="file_cover" name="file_cover" @change="onChangeBanner" accept=".zip" />
                                        <p class="mt-2 text-xs text-gray-400">.ZIP yang di Izinkan.</p>
                                    </div>
                                </div>
                            </form>
                        </VeeForm>
                    </div>
                    <div class="tab-panel" :class="form.update ? '' : 'hidden'">
                        <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                            <form @submit.prevent="handleSubmit($event, submitUpdate)">
                                <div class="mt-5 overflow-x-auto rounded-lg border border-gray-200" :class="form.export ? 'hidden' : ''">
                                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                        <thead class="text-left">
                                            <tr>
                                                <th class="px-4 py-2 font-medium text-gray-900">Book ID</th>
                                                <th class="px-4 py-2 font-medium text-gray-900">File Name</th>
                                                <th class="px-4 py-2 font-medium text-gray-900">Cover Name</th>
                                                <th class="px-4 py-2 font-medium text-gray-900">Category Book</th>
                                                <th class="px-4 py-2 font-medium text-gray-900">Publisher</th>
                                                <th class="px-4 py-2 font-medium text-gray-900">Format Book</th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-gray-200">
                                            <tr v-for="(file, key) in form.field.data_upl" :key="key">
                                                <td class="px-4 py-2 text-gray-700">{{ file.book_id }}</td>
                                                <td class="px-4 py-2 text-gray-700">{{ file.filename }}</td>
                                                <td class="px-4 py-2 text-gray-700">{{ file.cover }}</td>
                                                <td class="px-4 py-2 text-gray-700">
                                                    <select name="category" id="category" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" v-model="file.category_id">
                                                        <option value="">Select Category Book</option>
                                                        <option v-for="(value, key) in options.category" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </select>
                                                </td>
                                                <td class="px-4 py-2 text-gray-700">
                                                    <select name="publisher" id="publisher" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" v-model="file.publisher_id">
                                                        <option value="">Select Publisher</option>
                                                        <option v-for="(value, key) in options.publisher" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </select>
                                                </td>
                                                <td class="px-4 py-2 text-gray-700">
                                                    <select name="book_format" id="book_format" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" v-model="file.book_format_id">
                                                        <option value="">Select Publisher</option>
                                                        <option v-for="(value, key) in options.format" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </VeeForm>
                    </div>
                    <div class="tab-panel" :class="form.upload ? '' : 'hidden'">
                        <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                            <form @submit.prevent="handleSubmit($event, submitUploadExcel)">
                                <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
                                    <div class="h-32 font-[sans-serif]">
                                        <label class="mb-2 block text-base font-semibold text-gray-500">Upload file Excel</label>
                                        <input type="file" class="w-full cursor-pointer rounded border bg-white text-sm font-semibold text-gray-400 file:mr-4 file:cursor-pointer file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-gray-500 file:hover:bg-gray-200" aria-describedby="file_excel" ref="file_excel" id="file_excel" name="file_excel" @change="onFileExcelUpload" accept=".xlsx" />
                                        <p class="mt-2 text-xs text-gray-400">.XLSX are Allowed.</p>
                                    </div>
                                </div>
                            </form>
                        </VeeForm>
                    </div>
                    <div class="tab-panel" :class="form.review ? '' : 'hidden'">
                        <div class="mt-5 overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                <thead class="text-left">
                                    <tr>
                                        <th class="px-4 py-2 font-medium text-gray-900">Book ID</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Supplier</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Isbn</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Eisbn</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Title</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Writer</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Publisher</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Size</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Year</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Volume</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Edition</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Page</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Sinopsis</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Sellprice</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Rentprice</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Retailprice</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">City</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Category</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Book Format</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Filename</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Cover</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Age</th>
                                        <th class="px-4 py-2 font-medium text-gray-900">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="(file, key) in form.field.data_view" :key="key">
                                        <td class="px-4 py-2 text-gray-700">{{ file.book_id }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.supplier_id }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.isbn }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.eisbn }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.title }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.writer }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.publisher_id }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.size }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.year }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.volume }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.edition }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.page }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.sinopsis }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.sellprice }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.rentprice }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.retailprice }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.city }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.category_id }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.book_format_id }}</td>
                                        <td class="px-4 py-2 text-gray-700">
                                            <a href="javascript:void(0);" @click="downloadFile('books', file.filename)">
                                                <span class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 hover:bg-emerald-300 focus:relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>

                                                    <p class="whitespace-nowrap text-sm">Download Encrypt</p>
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-4 py-2 text-gray-700">
                                            <a href="javascript:void(0);" @click="downloadFile('covers', file.cover)">
                                                <span class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700 hover:bg-amber-300 focus:relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>

                                                    <p class="whitespace-nowrap text-sm">Download Cover</p>
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.age }}</td>
                                        <td class="px-4 py-2 text-gray-700">
                                            <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>

                                                <p class="whitespace-nowrap text-sm">Draft</p>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { DataTable } from 'simple-datatables'
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'

let dataTable
export default {
    components: {
        VeeForm,
        Field,
        ErrorMessage,
    },

    data() {
        return {
            options: {
                category: [],
                publisher: [],
                format: [],
            },

            form: {
                data: true,
                encrypt: false,
                update: false,
                upload: false,
                review: false,

                field: {
                    file_cover: '',
                    file_pdf: '',
                    data_upl: [],
                    data_view: [],
                    file_excel: null,
                },

                submitted: false,
                submit_count: 0,
            },
        }
    },

    mounted() {
        this.getData()
        this.getCategory()
        this.getPublisher()
        this.getFormat()

        dataTable = new DataTable('#default-table', {
            sortable: true,
            data: {
                headings: ['book_id', 'isbn', 'eisbn', 'title', 'writer', 'publisher_id', 'size', 'year', 'volume', 'edition', 'page', 'sinopsis', 'sellprice', 'rentprice', 'retailprice', 'city', 'category_id', 'book_format_id', 'filename', 'cover', 'age', 'status', 'reason', 'createdate', 'createby', 'updatedate', 'updateby'],
            },
            columns: [
                {
                    select: 18,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        return '<span class="whitespace-nowrap">' + data + '</span>'
                    },
                },
                {
                    select: 19,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        return '<span class="whitespace-nowrap">' + data + '</span>'
                    },
                },
                {
                    select: 21,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        return (
                            '<span class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">' +
                            '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />' +
                            '</svg>' +
                            '<p class="whitespace-nowrap text-sm">Review</p>' +
                            '</span>'
                        )
                    },
                },
                {
                    select: 23,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        return '<span class="whitespace-nowrap">' + data + '</span>'
                    },
                },
                {
                    select: 25,
                    type: 'string',
                    render: function (data, td, rowIndex, cellIndex) {
                        return '<span class="whitespace-nowrap">' + data + '</span>'
                    },
                },
            ],
        })
    },

    methods: {
        clearForm() {
            this.form.field.file_cover = ''
            this.form.field.file_pdf = ''
            this.form.field.file_excel = ''
            this.form.field.data_upl = []
            this.form.field.data_view = []

            this.$refs.file_cover.value = ''
            this.$refs.file_pdf.value = ''
            this.$refs.file_excel.value = ''
        },

        getData() {
            let loader = this.$loading.show()
            window.axios
                .get('/upload/encrypt-books')
                .then((response) => {
                    dataTable.data.data = []
                    dataTable.insert(response.data.data)

                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },

        getCategory() {
            this.options.category = []

            window.axios
                .get('/upload/encrypt-books/x0y0z0', {
                    params: {
                        param: 'category-mst',
                    },
                })
                .then((response) => {
                    this.options.category = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getPublisher() {
            this.options.publisher = []

            window.axios
                .get('/upload/encrypt-books/x0y0z0', {
                    params: {
                        param: 'publisher-mst',
                    },
                })
                .then((response) => {
                    this.options.publisher = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getFormat() {
            this.options.format = []

            window.axios
                .get('/upload/encrypt-books/x0y0z0', {
                    params: {
                        param: 'format-mst',
                    },
                })
                .then((response) => {
                    this.options.format = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getPreviewData() {
            this.form.field.data_view = []

            window.axios
                .get('/upload/encrypt-books/x0y0z0', {
                    params: {
                        param: 'preview-data',
                        data: this.form.field.data_upl,
                    },
                })
                .then((response) => {
                    this.form.field.data_view = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        async onChangeBanner(e) {
            this.form.field.file_cover = this.$refs.file_cover.files[0]
        },

        async onChangePdf(e) {
            this.form.field.file_pdf = this.$refs.file_pdf.files[0]
        },

        async onFileExcelUpload(e) {
            this.form.field.file_excel = this.$refs.file_excel.files[0]
        },

        encrypt() {
            this.form.data = false
            this.form.encrypt = true
            this.form.update = false
            this.form.upload = false
            this.form.review = false

            this.clearForm()
        },

        encryptUpdate() {
            this.form.data = false
            this.form.encrypt = false
            this.form.update = true
            this.form.upload = false
            this.form.review = false
        },

        encryptUpload() {
            this.form.data = false
            this.form.encrypt = false
            this.form.update = false
            this.form.upload = true
            this.form.review = false
        },

        encryptReview() {
            this.form.data = false
            this.form.encrypt = false
            this.form.update = false
            this.form.upload = false
            this.form.review = true

            this.getPreviewData()
        },

        cancelEncrypt() {
            this.form.data = true
            this.form.encrypt = false
            this.form.update = false
            this.form.upload = false
            this.form.review = false

            this.clearForm()
            this.$refs.form.resetForm()
            this.getData()
            dataTable.refresh()
        },

        cancelUpdate() {
            this.form.data = false
            this.form.encrypt = true
            this.form.update = false
            this.form.upload = false
            this.form.review = false
        },

        cancelUpload() {
            this.form.data = false
            this.form.encrypt = false
            this.form.update = true
            this.form.upload = false
            this.form.review = false
        },

        cancelReview() {
            this.form.data = false
            this.form.encrypt = false
            this.form.update = false
            this.form.upload = true
            this.form.review = false
        },

        submit() {
            if (!this.form.submitted) {
                this.form.submitted = true

                this.$refs.form.validate().then((result) => {
                    if (result.valid) {
                        this.form.submitted = false

                        let loader = this.$loading.show()
                        if (this.form.encrypt) {
                            let form_data = new FormData()
                            Object.keys(this.form.field).forEach((value) => {
                                form_data.append(value, this.form.field[value])
                            })

                            window.axios
                                .post('/upload/encrypt-books?menu=' + this.$route.name, form_data)
                                .then((response) => {
                                    this.form.field.data_upl = response.data.data
                                    this.$notyf.success('Successfully Encrypt file')
                                    this.encryptUpdate()
                                    loader.hide()
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
                        }
                    } else {
                        this.form.submitted = false
                    }
                })
            }
        },

        submitUpdate() {
            if (!this.form.submitted) {
                this.form.submitted = true

                this.$refs.form.validate().then((result) => {
                    if (result.valid) {
                        this.form.submitted = false

                        let loader = this.$loading.show()
                        if (this.form.update) {
                            window.axios
                                .put('/upload/encrypt-books/x0y0z0/?menu=' + this.$route.name, this.form.field.data_upl)
                                .then((response) => {
                                    this.encryptUpload()
                                    this.exportTpl()
                                    this.$notyf.success(response.data)
                                    loader.hide()
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
                        }
                    } else {
                        this.form.submitted = false
                    }
                })
            }
        },

        submitUploadExcel() {
            if (this.form.field.file_excel) {
                this.form.submit_count += 1
                if (this.form.submit_count === 1) {
                    let loader = this.$loading.show()

                    let form_data = new FormData()
                    form_data.append('file_master', this.form.field.file_excel)

                    window.axios
                        .post('/upload/encrypt-books-excel/upload?menufn=' + this.$route.name, form_data, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            },
                        })
                        .then((response) => {
                            this.form.submit_count = 0
                            this.encryptReview()
                            loader.hide()

                            this.$notyf.success(response.data)
                        })
                        .catch((e) => {
                            this.form.submit_count = 0
                            loader.hide()
                            console.log(e.response.data)
                        })
                }
            } else {
                this.$notyf.error('No file selected')
            }
        },

        submitReview() {
            if (!this.form.submitted) {
                this.form.submitted = true

                this.$refs.form.validate().then((result) => {
                    if (result.valid) {
                        this.form.submitted = false

                        if (this.form.review) {
                            let loader = this.$loading.show()

                            window.axios
                                .post('/upload/encrypt-books-submit/submit-draft?menu=' + this.$route.name, this.form.field.data_view)
                                .then((response) => {
                                    this.cancelEncrypt()
                                    loader.hide()
                                    this.$notyf.success(response.data)
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
                        }
                    } else {
                        this.form.submitted = false
                    }
                })
            }
        },

        async exportTpl() {
            await window
                .axios({
                    url: '/upload/encrypt-books-excel/export-tpl',
                    method: 'GET',
                    responseType: 'blob',
                    params: {
                        data: this.form.field.data_upl,
                    },
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'detail_data.xlsx')
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
        },

        async downloadFile(param, file) {
            await window
                .axios({
                    url: '/upload/encrypt-books-download/download-file',
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
    },
}
</script>
