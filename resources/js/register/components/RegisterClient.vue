<template>
    <section class="bg-white">
        <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
            <section class="relative flex h-32 items-start bg-gray-900 lg:col-span-5 lg:h-full xl:col-span-4">
                <img alt="" src="https://images.unsplash.com/photo-1617195737496-bc30194e3a19?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" class="absolute inset-0 h-full w-full object-cover opacity-80" />

                <div class="hidden lg:relative lg:block lg:p-12">
                    <a class="block text-white" href="/">
                        <span class="sr-only">Home</span>
                        <img class="w-40" src="images/logo/logo.svg" alt="logo" />
                    </a>

                    <h2 class="mt-6 text-2xl font-bold text-white sm:text-3xl md:text-4xl">Formulir Pendaftaran</h2>

                    <p class="mt-4 font-bold leading-relaxed text-white/90">Client</p>
                </div>
            </section>

            <main class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-8">
                <div class="max-w-xl lg:max-w-3xl">
                    <div class="relative -mt-16 block lg:hidden">
                        <a class="inline-flex size-16 items-center justify-center rounded-full bg-white text-blue-600 sm:size-20" href="#">
                            <span class="sr-only">Home</span>
                            <img src="images/logo/favicon.svg" alt="logo" />
                        </a>

                        <h1 class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">Formulir Pendaftaran</h1>

                        <p class="mt-4 leading-relaxed text-gray-500"></p>
                    </div>

                    <VeeForm ref="form" v-slot="{ handleSubmit, errors }" as="div">
                        <form class="mt-8 grid grid-cols-6 gap-4" @submit.prevent="handleSubmit($event, submit)">
                            <div class="col-span-6">
                                <label for="name" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.name ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="name" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Instansi" name="name" v-model="form.field.name" required autocomplete="name" autofocus />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Instansi</span>
                                </label>
                                <ErrorMessage name="name" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6">
                                <label for="name_apps" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.name_apps ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="name_apps" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Aplikasi" name="name_apps" v-model="form.field.name_apps" required autocomplete="name_apps" autofocus />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Aplikasi</span>
                                </label>
                                <ErrorMessage name="name_apps" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6">
                                <div class="flex items-center">
                                    <label for="web_add" class="relative block h-10 flex-1 rounded-l-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.web_add ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="web_add" class="peer h-full w-full rounded-l-md border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Alamat Website Perpustakaan" name="web_add" v-model="form.field.web_add" required autocomplete="web_add" autofocus />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Alamat Website Perpustakaan</span>
                                    </label>

                                    <span class="inline-flex h-10 items-center rounded-r-md border border-l-0 bg-gray-200 px-3 text-sm text-gray-500 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-400">.pustakadigital.id</span>
                                </div>
                                <ErrorMessage name="web_add" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6">
                                <Field as="textarea" id="address" class="mt-2 w-full rounded-lg align-top shadow-sm sm:text-sm" :class="errors.address ? 'border-red-500' : 'border-gray-200'" rows="3" placeholder="Masukkan alamat..." name="address" v-model="form.field.address" />
                                <ErrorMessage name="address" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <Field as="select" name="country" id="country" class="relative w-full rounded-md text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" :class="errors.country ? 'border-red-500' : 'border-gray-300'" v-model="form.field.country" @change="getProvinsi">
                                    <option value="">Silakan pilih Negara</option>
                                    <option value="IDN">Indonesia</option>
                                </Field>
                                <ErrorMessage name="country" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <Field as="select" name="province" id="province" class="relative w-full rounded-md text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" :class="errors.province ? 'border-red-500' : 'border-gray-300'" v-model="form.field.province" @change="getKabupaten">
                                    <option value="">Silakan pilih Provinsi</option>
                                    <option v-for="(value, key) in option.province" :key="key" :value="value.id">{{ value.name }}</option>
                                </Field>
                                <ErrorMessage name="province" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <Field as="select" name="regency" id="regency" class="relative w-full rounded-md text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" :class="errors.regency ? 'border-red-500' : 'border-gray-300'" v-model="form.field.regency" @change="getKecamatan">
                                    <option value="">Silakan pilih Kabupaten/Kota</option>
                                    <option v-for="(value, key) in option.regency" :key="key" :value="value.id">{{ value.name }}</option>
                                </Field>
                                <ErrorMessage name="regency" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <Field as="select" name="district" id="district" class="relative w-full rounded-md text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" :class="errors.district ? 'border-red-500' : 'border-gray-300'" v-model="form.field.district" @change="getKelurahan">
                                    <option value="">Silakan pilih Kecamatan</option>
                                    <option v-for="(value, key) in option.district" :key="key" :value="value.id">{{ value.name }}</option>
                                </Field>
                                <ErrorMessage name="district" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <Field as="select" name="subdistrict" id="subdistrict" class="relative w-full rounded-md text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" :class="errors.subdistrict ? 'border-red-500' : 'border-gray-300'" v-model="form.field.subdistrict">
                                    <option value="">Silakan pilih Kelurahan</option>
                                    <option v-for="(value, key) in option.subdistrict" :key="key" :value="value.id">{{ value.name }}</option>
                                </Field>
                                <ErrorMessage name="subdistrict" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="postal_code" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.postal_code ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="postal_code" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Kode Pos" name="postal_code" v-model="form.field.postal_code" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Kode Pos</span>
                                </label>
                                <ErrorMessage name="postal_code" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6">
                                <label for="npwp" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.npwp ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="npwp" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="No. NPWP" name="npwp" v-model="form.field.npwp" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">No. NPWP</span>
                                </label>
                                <ErrorMessage name="npwp" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="pers_responsible" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.pers_responsible ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="pers_responsible" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Penanggung Jawab" name="pers_responsible" v-model="form.field.pers_responsible" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Penanggung Jawab</span>
                                </label>
                                <ErrorMessage name="pers_responsible" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="pos_pers_responsible" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.pos_pers_responsible ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="pos_pers_responsible" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Jabatan Penanggung Jawab" name="pos_pers_responsible" v-model="form.field.pos_pers_responsible" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Jabatan Penanggung Jawab</span>
                                </label>
                                <ErrorMessage name="pos_pers_responsible" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="mou_sign_name" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.mou_sign_name ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="mou_sign_name" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Penandatanganan MOU" name="mou_sign_name" v-model="form.field.mou_sign_name" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Penandatanganan MOU</span>
                                </label>
                                <ErrorMessage name="mou_sign_name" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="pos_sign_name" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.pos_sign_name ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="pos_sign_name" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Jabatan Penandatanganan MOU" name="pos_sign_name" v-model="form.field.pos_sign_name" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Jabatan Penandatanganan MOU</span>
                                </label>
                                <ErrorMessage name="pos_sign_name" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="administrator_name" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.administrator_name ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="administrator_name" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Pengelola (Admin)" name="administrator_name" v-model="form.field.administrator_name" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Pengelola (Admin)</span>
                                </label>
                                <ErrorMessage name="administrator_name" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="administrator_phone" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.administrator_phone ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="administrator_phone" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nomor HP/WA (Admin)" name="administrator_phone" v-model="form.field.administrator_phone" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nomor HP/WA (Admin)</span>
                                </label>
                                <ErrorMessage name="administrator_phone" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <file-pond name="logo_big" ref="logo_big" label-idle="Upload Logo Besar disini..." v-bind:allow-multiple="false" accepted-file-types="image/png" maxFileSize="1000KB" v-on:init="handleFilePondInit" credits="false" v-on:updatefiles="getFile" />
                                <ErrorMessage name="logo_big" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                <dt class="text-xs font-medium text-slate-500">Max. logo size: 1000 kb</dt>
                                <img class="rounded-lg shadow-sm dark:shadow-gray-800" src="images/logo/logo.svg" alt="image description" />
                                <dt class="mt-2 text-xs font-medium text-slate-500">Contoh logo besar</dt>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <file-pond name="logo_small" ref="logo_small" label-idle="Upload Logo Kecil disini..." v-bind:allow-multiple="false" accepted-file-types="image/png" maxFileSize="1000KB" v-on:init="handleFilePondInit" credits="false" v-on:updatefiles="getFileSmall" />
                                <ErrorMessage name="logo_small" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                <dt class="text-xs font-medium text-slate-500">Max. logo size: 1000 kb</dt>
                                <img class="h-[125px] w-[125px] rounded-lg shadow-sm dark:shadow-gray-800" src="images/logo/favicon.svg" alt="image description" />
                                <dt class="mt-2 text-xs font-medium text-slate-500">Contoh logo kecil</dt>
                            </div>

                            <div class="col-span-6">
                                <label for="noref" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.noref ? 'border-red-500' : 'border-gray-200'">
                                    <Field type="text" id="noref" class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Kode Referensi" name="noref" v-model="form.field.noref" />

                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Kode Referensi</span>
                                </label>
                                <ErrorMessage name="noref" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6">
                                <label for="agreement" class="flex gap-4">
                                    <input type="checkbox" id="agreement" name="agreement" v-model="form.field.agreement" class="size-5 rounded-md border-gray-200 bg-white shadow-sm" disabled />

                                    <span class="text-sm text-red-700 underline"> Saya telah memahami dan menyetujui ketentuan dan persyaratan Pendaftaran Perpustakaan Digital Berbasis Website yang diajukan oleh pihak PT GINESIA DIGITAL INDONESIA. </span>
                                </label>
                                <ErrorMessage name="agreement" class="mt-1 block text-sm text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                                <button class="inline-block shrink-0 rounded-md border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500 disabled:opacity-75" :disabled="form.field.agreement ? false : true">Daftar</button>
                            </div>
                        </form>
                    </VeeForm>
                </div>
            </main>
        </div>
    </section>

    <!-- modal -->
    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" static>
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <ShieldExclamationIcon class="h-6 w-6 text-blue-600" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold text-gray-900">SYARAT DAN KETENTUAN</DialogTitle>
                                        <DialogTitle as="h3" class="text-base font-semibold text-gray-900">PENDAFTARAN PERPUSTAKAAN DIGITAL GINESIA</DialogTitle>
                                        <div class="mt-2 h-[62vh] overflow-scroll p-1">
                                            <div class="flow-root">
                                                <dl class="my-1 text-sm">
                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">1. Perpustakaan Digital GINESIA adalah platform aplikasi berbasis website.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">2. Platform ini tidak hanya menyediakan buku digital (ebook), tetapi juga berisi banner gambar, banner video, tajuk utama, frasa, wawasan, review buku, layer penulis, titik fokus, humoria, dan fitur-fitur lainnya yang akan terus dikembangkan.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">3. Nama Perpustakaan Digital pada Platform GINESIA akan menggunakan nama Lembaga Perpustakaan, sesuai dengan ketetapan dari pihak tersebut.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">4. Nama yang dipilih bersifat eksklusif dan tidak akan diberikan kepada lembaga lain.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">5. Penggantian nama perpustakaan diperbolehkan, tetapi harus disertai dengan penambahan koleksi perpustakaan sesuai ketentuan yang ditetapkan oleh pemilik platform setiap tahun.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">6. Apabila dua Lembaga Perpustakaan pengguna Platform GINESIA melakukan merger (penggabungan), perpustakaan digital masing-masing dapat digabung dengan syarat pengisian surat pernyataan merger dan penambahan koleksi senilai minimal Rp. 3.000.000,-.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">7. Koleksi perpustakaan yang dibeli bersifat hak milik, namun PT. Ginesia Digital Indonesia tidak berkewajiban melakukan pembaruan atau perbaikan kecuali jika Pihak Lembaga Perpustakaan telah melakukan penambahan koleksi selama tahun berjalan.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">8. Hak milik perpustakaan ini terbatas pada usia teknologi website. Jika teknologi website tidak lagi digunakan, maka hak milik juga berakhir.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">9. PT. Ginesia Digital Indonesia menyediakan versi offline dengan ketentuan minimal pembelian koleksi perpustakaan, sesuai dengan ketentuan terpisah.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">10. Koleksi perpustakaan dapat diperoleh melalui pembelian, hibah, atau donasi.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">11. Semua pembelian buku digital harus melalui Distributor yang dipilih oleh Pihak Pembeli (Lembaga Perpustakaan).</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">12. Setiap judul ebook yang dibeli minimal sebanyak 2 copy.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">13. Jika Distributor yang dipilih tidak memenuhi kewajiban pembayaran kepada PT. Ginesia Digital Indonesia, maka Pihak Ginesia berhak menurunkan koleksi terkait dari platform.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">14. PT. Ginesia Digital Indonesia akan meningkatkan versi perpustakaan digital setiap tahun. Fitur-fitur tertentu hanya dapat diakses pada versi terbaru, dan Lembaga Perpustakaan harus melakukan pembelian koleksi untuk menikmati pembaruan otomatis.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">15. Selain ebook, produk digital yang disediakan oleh PT. Ginesia Digital Indonesia di antaranya: ebook media interaktif, audiobook, videobook, video tutorial dan konten digital lainnya yang akan terus dikembangkan.</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">16. Pihak Lembaga Perpustakaan membayar Biaya Lisensi senilai Rp. 150.000,- dalam 1 tahun untuk tetap menikmati semua layanan fitur dan konten platform Ginesia, namun jika dalam 1 tahun ada pembelian koleksi minimal senilai Rp. 1.000.000,-, maka tidak ada biaya lisensi (gratis).</dd>
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-1 py-1 sm:grid-cols-1 sm:gap-1">
                                                        <dd class="text-gray-700 sm:col-span-2">Saya telah memahami dan menyetujui ketentuan dan persyaratan Pendaftaran Perpustakaan Digital Berbasis Website yang diajukan oleh pihak PT GINESIA DIGITAL INDONESIA.</dd>
                                                    </div>
                                                </dl>
                                            </div>

                                            <p class="text-sm text-gray-600">
                                                <label for="agreement" class="flex gap-4">
                                                    <input type="checkbox" id="agreement" name="agreement" v-model="form.field.agreement" class="size-5 rounded-md border-gray-200 bg-white shadow-sm" />

                                                    <span class="text-sm text-red-700 underline"> Saya Setuju. </span>
                                                </label>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 sm:ml-3 sm:w-auto" @click="open = false" :disabled="form.field.agreement ? false : true">Setuju</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <TransitionRoot as="template" :show="open_finish">
        <Dialog class="relative z-10" @close="(open_finish = false), (open = true)">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <CheckBadgeIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold text-gray-900">Selamat Anda Berhasil Registrasi</DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Registrasi akan di proses dalam kurun waktu 7x24 jam Terima Kasih.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="(open_finish = false), (open = true)" ref="cancelButtonRef">Tutup</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <!-- modal -->
</template>

<script>
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ShieldExclamationIcon } from '@heroicons/vue/24/outline'
import { CheckBadgeIcon } from '@heroicons/vue/24/outline'

export default {
    components: {
        VeeForm,
        Field,
        ErrorMessage,
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ShieldExclamationIcon,
        CheckBadgeIcon,
    },

    data() {
        return {
            open: false,
            open_finish: false,
            search: '',

            option: {
                province: [],
                regency: [],
                district: [],
                subdistrict: [],
            },

            form: {
                field: {
                    name: '',
                    name_apps: '',
                    web_add: '',
                    address: '',
                    country: '',
                    province: '',
                    regency: '',
                    district: '',
                    subdistrict: '',
                    postal_code: '',
                    npwp: '',
                    pers_responsible: '',
                    pos_pers_responsible: '',
                    mou_sign_name: '',
                    pos_sign_name: '',
                    administrator_name: '',
                    administrator_phone: '',
                    logo_big: '',
                    logo_small: '',
                    agreement: false,
                    noref: '',
                },
            },
        }
    },

    mounted() {
        this.open = true
    },

    methods: {
        clearForm() {
            this.form.field.name = ''
            this.form.field.name_apps = ''
            this.form.field.web_add = ''
            this.form.field.address = ''
            this.form.field.country = ''
            this.form.field.province = ''
            this.form.field.regency = ''
            this.form.field.district = ''
            this.form.field.subdistrict = ''
            this.form.field.postal_code = ''
            this.form.field.npwp = ''
            this.form.field.pers_responsible = ''
            this.form.field.pos_pers_responsible = ''
            this.form.field.mou_sign_name = ''
            this.form.field.pos_sign_name = ''
            this.form.field.administrator_name = ''
            this.form.field.administrator_phone = ''
            this.form.field.logo_big = ''
            this.form.field.logo_small = ''
            this.form.field.agreement = false
            this.form.field.noref = ''

            this.$refs.logo_big.removeFiles()
            this.$refs.logo_small.removeFiles()
        },

        handleFilePondInit: function () {},

        getFile() {
            const files = this.$refs.logo_big.getFiles()
            if (files.length > 0) {
                this.form.field.logo_big = files[0].file
            } else {
                this.form.field.logo_big = null
            }
        },

        getFileSmall() {
            const files = this.$refs.logo_small.getFiles()
            if (files.length > 0) {
                this.form.field.logo_small = files[0].file
            } else {
                this.form.field.logo_small = null
            }
        },

        getProvinsi() {
            this.form.field.province = ''
            this.form.field.regency = ''
            this.form.field.district = ''
            this.form.field.subdistrict = ''
            this.option.province = []

            let loader = this.$loading.show()
            window.axios
                .get('/options/x0y0z0', {
                    params: {
                        param: 'provinsi-mst',
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.option.province = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getKabupaten() {
            this.form.field.regency = ''
            this.form.field.district = ''
            this.form.field.subdistrict = ''
            this.option.regency = []

            let loader = this.$loading.show()
            window.axios
                .get('/options/x0y0z0', {
                    params: {
                        param: 'kabupaten-mst',
                        provinsi: this.form.field.province,
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.option.regency = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getKecamatan() {
            this.form.field.district = ''
            this.form.field.subdistrict = ''
            this.option.district = []

            let loader = this.$loading.show()
            window.axios
                .get('/options/x0y0z0', {
                    params: {
                        param: 'kecamatan-mst',
                        provinsi: this.form.field.province,
                        kabupaten: this.form.field.regency,
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.option.district = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getKelurahan() {
            this.form.field.subdistrict = ''
            this.option.subdistrict = []

            let loader = this.$loading.show()
            window.axios
                .get('/options/x0y0z0', {
                    params: {
                        param: 'kelurahan-mst',
                        provinsi: this.form.field.province,
                        kabupaten: this.form.field.regency,
                        kecamatan: this.form.field.district,
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.option.subdistrict = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        async submit() {
            let loader = this.$loading.show()
            try {
                let form_data = new FormData()
                Object.keys(this.form.field).forEach((value) => {
                    form_data.append(value, this.form.field[value])
                })
                const response = await window.axios.post('/pendaftaran-client', form_data)
                this.clearForm()
                loader.hide()
                this.open_finish = true
                this.$notyf.success(response.data.message || 'Register successful!')
            } catch (e) {
                loader.hide()
                this.$refs.form.setErrors(e.response.data.errors)

                if (e.response && e.response.data && e.response.data.message) {
                    this.$notyf.error(e.response.data.message)
                } else {
                    this.$notyf.error(e.message || 'An error occurred.')
                }
            }
        },
    },

    computed: {},
}
</script>
