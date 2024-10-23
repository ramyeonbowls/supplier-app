<template>
    <div class="rounded-2xl border border-blue-100 bg-white p-4 shadow-lg sm:p-6 lg:p-8" role="alert">
        <div class="flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
            </svg>

            <p class="font-medium sm:text-lg">Verifikasi Alamat Email Anda!</p>
        </div>

        <p class="mt-4 text-gray-500">Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi. Jika Anda tidak menerima email</p>

        <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
            <form @submit.prevent="handleSubmit($event, submit)">
                <div class="mt-6 sm:flex sm:gap-4">
                    <button type="submit" class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-600 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500">
                        <span class="absolute -start-full transition-all group-hover:start-4">
                            <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4"> Klik di sini untuk meminta yang lain </span>
                    </button>
                </div>
            </form>
        </VeeForm>
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

    methods: {
        async submit() {
            try {
                const response = await window.axios.post('/email/resend')
                this.$notyf.success(response.data.message || 'Verification Resend successful!')
            } catch (e) {
                if (e.response && e.response.data && e.response.data.message) {
                    this.$notyf.error(e.response.data.message)
                } else {
                    this.$notyf.error(e.message || 'An error occurred.')
                }
            }
        },
    },
}
</script>
