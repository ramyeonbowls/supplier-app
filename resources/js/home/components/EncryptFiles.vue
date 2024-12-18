<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click.prevent="submit">
                        <span class="absolute -start-full transition-all group-hover:start-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4"> Enkripsi File </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex flex-grow flex-col p-6">
            <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                <form @submit.prevent="handleSubmit($event, submit)">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
                        <div class="h-32 rounded-md border p-2 font-[sans-serif] shadow-sm">
                            <file-pond
                                name="file_pdf"
                                ref="file_pdf"
                                label-idle='<div class="flex justify-center gap-1 items-center"><div class="p-3 items-center"><svg class="size-8 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg></div><div>Upload file zip pdf buku untuk di enkripsi...</div></div>'
                                :allow-multiple="false"
                                accepted-file-types="zip,application/zip,application/x-zip,application/x-zip-compressed"
                                label-file-type-not-allowed="Hanya file ZIP yang diperbolehkan."
                                file-validate-type-label-expected-types="Memerlukan file ZIP"
                                max-file-size="300MB"
                                v-on:init="handleFilePondInit"
                                credits="false"
                                v-on:updatefiles="onChangePdf"
                                style-class="custom-filepond"
                            />
                            <dt class="text-xs font-medium text-slate-500"><span class="text-red-500">*</span> Ukuran maksimal <span class="font-bold text-red-500">file .Zip 300mb</span> & Setiap <span class="font-bold text-red-500">file .Pdf maksimal 20mb</span>.</dt>
                        </div>
                    </div>
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
            form: {
                field: {
                    file_pdf: '',
                },

                submitted: false,
            },
        }
    },

    mounted() {
        this.clearForm()
    },

    methods: {
        clearForm() {
            this.form.submitted = false
            this.form.field.file_pdf = ''
            this.$refs.file_pdf.removeFiles()
        },

        handleFilePondInit: function () {},

        onChangePdf() {
            const files = this.$refs.file_pdf.getFiles()
            if (files.length > 0) {
                this.form.field.file_pdf = files[0].file
            } else {
                this.form.field.file_pdf = null
            }
        },

        submit() {
            if (!this.form.submitted) {
                this.form.submitted = true

                this.$refs.form.validate().then((result) => {
                    if (result.valid) {
                        this.form.submitted = false

                        let loader = this.$loading.show()

                        let form_data = new FormData()
                        Object.keys(this.form.field).forEach((value) => {
                            form_data.append(value, this.form.field[value])
                        })

                        window.axios
                            .post('/upload/encrypt-files?menu=' + this.$route.name, form_data)
                            .then((response) => {
                                loader.hide()

                                if (response.data.file.length > 0) {
                                    response.data.file.forEach((element) => {
                                        this.downloadFile(element)
                                        this.$notyf.success('Successfully download file ' + element)
                                    })

                                    this.exportTpl(response.data.filename)
                                    this.$notyf.success('Successfully download file Excel')
                                }

                                this.clearForm()
                                this.$notyf.success('Successfully Encrypt file')
                            })
                            .catch((e) => {
                                this.form.submitted = false
                                this.clearForm()
                                loader.hide()

                                if (e.response && e.response.data && e.response.data.message) {
                                    this.$notyf.error(e.response.data.message)
                                } else {
                                    this.$notyf.error(e.message || 'An error occurred.')
                                }
                            })
                    }
                })
            }
        },

        async downloadFile(file) {
            let loader = this.$loading.show()
            await window
                .axios({
                    url: '/upload/encrypt-files-download/download-file',
                    method: 'GET',
                    responseType: 'blob',
                    params: {
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
                    loader.hide()
                })
                .catch((e) => {
                    console.log(e.response.data)
                    loader.hide()
                })
        },

        async exportTpl(filename) {
            await window
                .axios({
                    url: '/upload/encrypt-files-download/export-tpl',
                    method: 'POST',
                    responseType: 'blob',
                    data: {
                        data: filename,
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
    },
}
</script>
