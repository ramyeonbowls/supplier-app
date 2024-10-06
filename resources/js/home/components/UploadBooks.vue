<template>
<div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="z-50 border-b border-gray-200 p-4">
            <div class="flex h-12 w-full items-center justify-between">
                <div class="button">
                    <span class="inline-flex -space-x-px overflow-hidden rounded-md border bg-indigo-400 shadow-sm">
                        <button class="inline-block px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500 focus:relative" @click.prevent="submit">Upload</button>
                        <button class="inline-block px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500 focus:relative">Export</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                <form @submit.prevent="handleSubmit($event, submit)">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
                        <div class="h-32 rounded-lg bg-slate-200 p-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_cover">Upload file Zip Cover</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" ref="file_cover" id="file_cover" name="file_cover" type="file" @change="onChangeBanner" accept=".zip">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">File types: Zip.</p>
                        </div>
                        <div class="h-32 rounded-lg bg-slate-200 p-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_pdf">Upload file Zip PDF</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" ref="file_pdf" id="file_pdf" name="file_pdf" type="file" @change="onChangePdf" accept=".zip">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">File types: Zip.</p>
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
                submitted: false,
                field: {
                    file_cover: '',
                    file_pdf: '',
                }
            },
        }
    },

    mounted() {
        this.clearForm()
    },

    methods: {
        clearForm() {
            this.form.field.file_cover = ''
            this.form.field.file_pdf = ''

            this.$refs.file_cover.value = ''
            this.$refs.file_pdf.value = ''
        },

        async onChangeBanner(e) {
            this.form.field.file_cover = this.$refs.file_cover.files[0];
        },

        async onChangePdf(e) {
            this.form.field.file_pdf = this.$refs.file_pdf.files[0];
        },

        submit() {
            if(!this.form.submitted) {
                this.form.submitted = true;

                this.$refs.form.validate().then(result => {
                    if(result.valid) {
                        this.form.submitted = false;

                        let form_data = new FormData();
                        Object.keys(this.form.field).forEach(value => {
                            form_data.append(value, this.form.field[value]);
                        });
                        
                        window.axios.post('/upload/encrypt-books?menu='+ this.$route.name, form_data)
                            .then((response) => {
                                console.log(response)
                            })
                            .catch((e) => {
                                this.form.submitted = false;

                                if (e.response && e.response.data && e.response.data.message) {
                                    this.$notyf.error(e.response.data.message)
                                } else {
                                    this.$notyf.error(e.message || 'An error occurred.')
                                }
                            });
                    } else {
                        this.form.submitted = false;
                    }
                });
            }
        },
    },
}
</script>