<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click.prevent="submit">
                        <span class="absolute -start-full transition-all group-hover:start-4">
                            <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4"> Enkripsi File </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="p-6">
            <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                <form @submit.prevent="handleSubmit($event, submit)">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
                        <div class="h-32 font-[sans-serif]">
                            <label class="mb-2 block text-base font-semibold text-red-500">UPLOAD FILE ZIP PDF BUKU UNTUK DI ENKRIPSI</label>
                            <input type="file" class="w-full cursor-pointer rounded border bg-white text-sm font-semibold text-gray-400 file:mr-4 file:cursor-pointer file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-gray-500 file:hover:bg-gray-200" aria-describedby="file_pdf" ref="file_pdf" id="file_pdf" name="file_pdf" @change="onChangePdf" accept=".zip" />
                            <p class="mt-2 text-xs text-gray-400">.ZIP yang di Izinkan.</p>
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
            this.$refs.file_pdf.value = ''
        },

        async onChangePdf(e) {
            this.form.field.file_pdf = this.$refs.file_pdf.files[0]
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

                                if (response.data.file != '') {
                                    this.downloadFile(response.data.file)
                                }
                                
                                this.clearForm()
                                this.$notyf.success('Successfully Encrypt file')
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
                })
            }
        },

        async downloadFile(file) {
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
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
        },
    },
}
</script>
