<template>
    <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-lg">
            <div class="flex items-center justify-center">
                <img class="w-[50%]" src="images/logo/logo.svg" alt="logo" />
            </div>

            <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                <form class="mb-0 mt-6 space-y-4 rounded-lg p-4 shadow-lg sm:p-6 lg:p-8" @submit.prevent="handleSubmit($event, submit)">
                    <div class="space-y-0 text-center">
                        <p class="text-lg font-medium text-gray-700">Masuk ke Akun Dashboard</p>
                        <p class="text-sm text-gray-500">Sebagai Supplier</p>
                    </div>

                    <div>
                        <label for="email" class="relative block rounded-md border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600">
                            <input type="email" id="email" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Enter email" name="email" v-model="form.field.email" required autocomplete="email" autofocus />

                            <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Enter email</span>

                            <span class="absolute inset-y-0 end-0 grid place-content-center px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </span>
                        </label>
                    </div>

                    <div>
                        <label for="password" class="relative block rounded-md border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600">
                            <input :type="!show ? 'password' : 'text'" id="password" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Enter password" name="password" v-model="form.field.password" required autocomplete="current-password" />

                            <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Password</span>

                            <span class="absolute inset-y-0 end-0 grid place-content-center px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" :class="{ block: !show, hidden: show }" fill="none" viewBox="0 0 24 24" stroke="currentColor" @click="show = true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" :class="{ block: show, hidden: !show }" fill="none" viewBox="0 0 24 24" stroke="currentColor" @click="show = false">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="block w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white">Masuk</button>

                    <p class="text-center text-sm text-gray-500">
                        Belum punya akun Supplier?
                        <a class="underline" href="/pendaftaran-supplier">Daftar</a>
                    </p>
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
            show: false,

            form: {
                field: {
                    email: '',
                    password: '',
                },
            },
        }
    },

    mounted() {},

    methods: {
        async submit() {
            try {
                const response = await window.axios.post('/login', this.form.field)
                this.$notyf.success(response.data.message || 'Login successful!')
                window.location.href = '/'
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
