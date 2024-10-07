<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="z-50 border-b border-gray-200 p-4">
            <div class="flex h-12 w-full items-center justify-between">
                <div class="button">
                    <template v-if="!form.update && !form.export">
                        <span class="inline-flex -space-x-px overflow-hidden rounded-md border bg-indigo-400 shadow-sm">
                            <button class="inline-block px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500 focus:relative" @click.prevent="submit">Encrypt File</button>
                        </span>
                    </template>
                    <template v-else-if="form.update && !form.export">
                        <span class="inline-flex -space-x-px overflow-hidden rounded-md border bg-indigo-400 shadow-sm">
                            <button class="inline-block px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500 focus:relative" @click.prevent="submit">Update Data</button>
                        </span>
                    </template>
                    <template v-else>
                        <span class="inline-flex -space-x-px overflow-hidden rounded-md border bg-indigo-400 shadow-sm">
                            <button class="inline-block px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500 focus:relative" @click.prevent="submitUploadExcel">Upload File</button>
                        </span>
                    </template>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div>
                <h2 class="sr-only">Steps</h2>

                <div>
                    <template v-if="!form.update && !form.export && !form.preview">
                        <p class="text-sm font-medium text-gray-500">1/4 - Encrypt File</p>
                    </template>
                    <template v-else-if="form.update && !form.export && !form.preview">
                        <p class="text-sm font-medium text-gray-500">2/4 - Update Details</p>
                    </template>
                    <template v-else-if="form.update && form.export && !form.preview">
                        <p class="text-sm font-medium text-gray-500">3/4 - Export File</p>
                    </template>
                    <template v-else>
                        <p class="text-sm font-medium text-gray-500">4/4 - Preview</p>
                    </template>

                    <div class="mt-4 overflow-hidden rounded-full bg-gray-200">
                        <template v-if="!form.update && !form.export && !form.preview">
                            <div class="h-2 w-1/4 rounded-full bg-blue-500"></div>
                        </template>
                        <template v-else-if="form.update && !form.export && !form.preview">
                            <div class="h-2 w-1/3 rounded-full bg-blue-500"></div>
                        </template>
                        <template v-else-if="form.update && form.export && !form.preview">
                            <div class="h-2 w-4/5 rounded-full bg-blue-500"></div>
                        </template>
                        <template v-else>
                            <div class="h-2 w-full rounded-full bg-blue-500"></div>
                        </template>
                    </div>
                </div>
            </div>

            <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                <form class="mt-5" @submit.prevent="handleSubmit($event, submit)">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8" :class="form.update ? 'hidden' : ''">
                        <div class="h-32 rounded-lg bg-slate-200 p-4">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="file_cover">Upload file Zip Cover</label>
                            <input class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400" aria-describedby="file_cover" ref="file_cover" id="file_cover" name="file_cover" type="file" @change="onChangeBanner" accept=".zip" :disabled="form.update" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_cover">File types: Zip.</p>
                        </div>
                        <div class="h-32 rounded-lg bg-slate-200 p-4">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="file_pdf">Upload file Zip PDF</label>
                            <input class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400" aria-describedby="file_pdf" ref="file_pdf" id="file_pdf" name="file_pdf" type="file" @change="onChangePdf" accept=".zip" :disabled="form.update" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_pdf">File types: Zip.</p>
                        </div>
                    </div>
                    <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8" :class="!form.export || form.preview ? 'hidden' : ''">
                        <div class="h-32 rounded-lg bg-slate-200 p-4">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="file_excel">Upload Excel</label>
                            <input class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400" aria-describedby="file_excel" ref="file_excel" id="file_excel" name="file_excel" type="file" @change="onFileExcelUpload" accept=".xlsx" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_excel">File types: xlsx.</p>
                        </div>
                    </div>
                    <template v-if="form.data.length > 0">
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
                                    <tr v-for="(file, key) in form.data" :key="key">
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
                    </template>
                    <template v-if="form.data_preview.length > 0">
                        <div class="mt-5 overflow-x-auto rounded-lg border border-gray-200" :class="!form.preview ? 'hidden' : ''">
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
                                    <tr v-for="(file, key) in form.data_preview" :key="key">
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
                                        <td class="px-4 py-2 text-gray-700">{{ file.filename }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.cover }}</td>
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
                    </template>
                </form>
            </VeeForm>
        </div>
    </div>
</template>

<script>
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'

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
                update: false,
                export: false,
                preview: false,
                submitted: false,
                submit_count: 0,
                field: {
                    file_cover: '',
                    file_pdf: '',
                },
                data: [],
                data_preview: [],
                file_excel: null,
            },
        }
    },

    mounted() {
        this.clearForm()
        this.getCategory()
        this.getPublisher()
        this.getFormat()
    },

    methods: {
        clearForm() {
            this.form.field.file_cover = ''
            this.form.field.file_pdf = ''
            this.form.file_excel = ''

            this.$refs.file_cover.value = ''
            this.$refs.file_pdf.value = ''
            this.$refs.file_excel.value = ''
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
            this.form.data_preview = []

            window.axios
                .get('/upload/encrypt-books/x0y0z0', {
                    params: {
                        param: 'preview-data',
                        data: this.form.data,
                    },
                })
                .then((response) => {
                    this.form.data_preview = response.data
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
            this.form.file_excel = this.$refs.file_excel.files[0]
        },

        submit() {
            if (!this.form.submitted) {
                this.form.submitted = true

                this.$refs.form.validate().then((result) => {
                    if (result.valid) {
                        this.form.submitted = false

                        if (!this.form.update) {
                            let form_data = new FormData()
                            Object.keys(this.form.field).forEach((value) => {
                                form_data.append(value, this.form.field[value])
                            })

                            window.axios
                                .post('/upload/encrypt-books?menu=' + this.$route.name, form_data)
                                .then((response) => {
                                    this.form.data = response.data.data
                                    this.form.update = true

                                    response.data.error.forEach((data) => {
                                        this.$notyf.error(data)
                                    })

                                    response.data.message.forEach((data) => {
                                        this.$notyf.success(data)
                                    })

                                    this.clearForm()
                                })
                                .catch((e) => {
                                    this.form.submitted = false

                                    if (e.response && e.response.data && e.response.data.message) {
                                        this.$notyf.error(e.response.data.message)
                                    } else {
                                        this.$notyf.error(e.message || 'An error occurred.')
                                    }
                                })
                        } else {
                            window.axios
                                .put('/upload/encrypt-books/x0y0z0/?menu=' + this.$route.name, this.form.data)
                                .then((response) => {
                                    this.clearForm()
                                    this.exportTpl()
                                    this.form.export = true
                                    this.$notyf.success(response.data)
                                })
                                .catch((e) => {
                                    this.form.submitted = false

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
                        data: this.form.data,
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

        submitUploadExcel() {
            if (this.form.file_excel) {
                this.form.submit_count += 1
                if (this.form.submit_count === 1) {
                    let form_data = new FormData()
                    form_data.append('file_master', this.form.file_excel)

                    window.axios
                        .post('/upload/encrypt-books-excel/upload?menufn=' + this.$route.name, form_data, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            },
                        })
                        .then((response) => {
                            this.form.submit_count = 0
                            this.form.preview = true
                            this.getPreviewData()
                            this.clearForm()

                            this.$notyf.success(response.data)
                        })
                        .catch((e) => {
                            this.form.submit_count = 0
                            console.log(e.response.data)
                        })
                }
            } else {
                this.$notyf.error('No file selected')
            }
        },
    },
}
</script>
