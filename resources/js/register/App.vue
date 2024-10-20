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

                    <p class="mt-4 font-bold leading-relaxed text-white/90">Supplier</p>
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
                                <label for="supplier" class="flex cursor-pointer items-start gap-2 rounded-lg border border-gray-200 p-4 transition hover:bg-gray-50 has-[:checked]:bg-blue-50">
                                    <div class="flex items-center">
                                        &#8203;
                                        <input type="checkbox" class="single-checkbox size-4 rounded border-gray-300" id="supplier" name="supplier" v-model="form.field.supplier" disabled />
                                    </div>

                                    <div>
                                        <strong class="font-medium text-gray-900"> Supplier </strong>

                                        <p class="mt-1 text-pretty text-xs text-gray-700">Daftar Supplier.</p>
                                    </div>
                                </label>
                                <ErrorMessage name="supplier" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <!-- <div class="col-span-6 sm:col-span-2">
                                <label for="distributor" class="flex cursor-pointer items-start gap-2 rounded-lg border border-gray-200 p-4 transition hover:bg-gray-50 has-[:checked]:bg-blue-50">
                                    <div class="flex items-center">
                                        &#8203;
                                        <input type="checkbox" class="single-checkbox size-4 rounded border-gray-300" id="distributor" name="distributor" v-model="form.field.distributor" />
                                    </div>

                                    <div>
                                        <strong class="font-medium text-gray-900"> Distributor </strong>

                                        <p class="mt-1 text-pretty text-xs text-gray-700">Daftar Distributor.</p>
                                    </div>
                                </label>
                                <ErrorMessage name="distributor" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="supp_distributor" class="flex cursor-pointer items-start gap-2 rounded-lg border border-gray-200 p-4 transition hover:bg-gray-50 has-[:checked]:bg-blue-50">
                                    <div class="flex items-center">
                                        &#8203;
                                        <input type="checkbox" class="single-checkbox size-4 rounded border-gray-300" id="supp_distributor" name="supp_distributor" v-model="form.field.supp_distributor" />
                                    </div>

                                    <div>
                                        <strong class="font-medium text-gray-900"> Distributor & Supplier </strong>

                                        <p class="mt-1 whitespace-nowrap text-pretty text-xs text-gray-700">Daftar Distributor & Supplier.</p>
                                    </div>
                                </label>
                                <ErrorMessage name="supp_distributor" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                            </div> -->

                            <template v-if="form.field.supplier || form.field.distributor || form.field.supp_distributor">
                                <div class="col-span-6">
                                    <label for="name" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.name ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="name" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Perusahaan" name="name" v-model="form.field.name" required autocomplete="name" autofocus />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Perusahaan</span>
                                    </label>
                                    <ErrorMessage name="name" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6">
                                    <label for="email" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.email ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="email" id="email" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Email" name="email" v-model="form.field.email" required autocomplete="email" autofocus />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Email</span>
                                    </label>
                                    <ErrorMessage name="email" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.password ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="password" id="password" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Enter password" name="password" v-model="form.field.password" required autocomplete="current-password" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Password</span>
                                    </label>
                                    <ErrorMessage name="password" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password_confirmation" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.password_confirmation ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="password" id="password_confirmation" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Konfirmasi Password" name="password_confirmation" v-model="form.field.password_confirmation" required autocomplete="new-password" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Konfirmasi Password</span>
                                    </label>
                                    <ErrorMessage name="password_confirmation" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
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
                                        <Field type="text" id="postal_code" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Kode Pos" name="postal_code" v-model="form.field.postal_code" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Kode Pos</span>
                                    </label>
                                    <ErrorMessage name="postal_code" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6">
                                    <Field as="textarea" id="address" class="mt-2 w-full rounded-lg align-top shadow-sm sm:text-sm" :class="errors.address ? 'border-red-500' : 'border-gray-200'" rows="3" placeholder="Masukkan alamat..." name="address" v-model="form.field.address" />
                                    <ErrorMessage name="address" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 hidden sm:col-span-3">
                                    <label for="telephone" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.telephone ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="telephone" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="No. Telephone" name="telephone" v-model="form.field.telephone" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">No. Telephone</span>
                                    </label>
                                    <ErrorMessage name="telephone" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6">
                                    <label for="handphone" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.handphone ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="handphone" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="No. Handphone" name="handphone" v-model="form.field.handphone" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">No. Handphone</span>
                                    </label>
                                    <ErrorMessage name="handphone" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6">
                                    <label for="director" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.director ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="director" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Direktur" name="director" v-model="form.field.director" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Direktur</span>
                                    </label>
                                    <ErrorMessage name="director" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="position" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.position ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="position" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Jabatan" name="position" v-model="form.field.position" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Jabatan</span>
                                    </label>
                                    <ErrorMessage name="position" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="handphone_director" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.handphone_director ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="handphone_director" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="No. Handphone Direktur" name="handphone_director" v-model="form.field.handphone_director" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">No. Handphone Direktur</span>
                                    </label>
                                    <ErrorMessage name="handphone_director" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="person_in_charge" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.person_in_charge ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="person_in_charge" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Penanggung Jawab" name="person_in_charge" v-model="form.field.person_in_charge" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Penanggung Jawab</span>
                                    </label>
                                    <ErrorMessage name="person_in_charge" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="handphone_person_in_charge" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.handphone_person_in_charge ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="handphone_person_in_charge" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="No. Handphone Penanggung Jawab" name="handphone_person_in_charge" v-model="form.field.handphone_person_in_charge" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">No. Handphone Penanggung Jawab</span>
                                    </label>
                                    <ErrorMessage name="handphone_person_in_charge" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6" :class="form.field.supplier || form.field.supp_distributor ? '' : 'hidden'">
                                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                            <thead class="justify-between text-center">
                                                <tr>
                                                    <th class="w-[80%] whitespace-nowrap px-4 py-2 font-bold text-gray-700">Imprint Data</th>
                                                    <th class="w-[20%] whitespace-nowrap px-4 py-2 font-medium text-blue-600">
                                                        <button type="button" @click="addImprint">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="items-center divide-y divide-gray-200">
                                                <template v-if="form.field.imprint.length > 0">
                                                    <tr v-for="(imprint, key) in form.field.imprint" :key="key">
                                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                                            <label :for="'imprint_' + (key + 1)" class="relative block overflow-hidden border-b border-gray-200 bg-transparent pt-3 focus-within:border-blue-600">
                                                                <input type="text" :id="'imprint_' + (key + 1)" :placeholder="'Imprint ' + (key + 1)" class="peer h-8 w-full border-none bg-transparent p-0 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm" :name="'imprint_' + (key + 1)" v-model="imprint.name" />

                                                                <span class="absolute start-0 top-2 -translate-y-1/2 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs"> Imprint {{ key + 1 }} </span>
                                                            </label>
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-center text-red-600">
                                                            <button type="button" @click="delImprint(imprint)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                                                    />
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td colspan="2" class="whitespace-nowrap px-4 py-2 text-center text-gray-700">
                                                            <div>Klik tombol plus untuk menambahkan</div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-span-6" :class="form.field.supplier || form.field.supp_distributor ? '' : 'hidden'">
                                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                            <thead class="justify-between text-center">
                                                <tr>
                                                    <th class="w-[80%] whitespace-nowrap px-4 py-2 font-bold text-gray-700">Penerbit yang Memberi Kuasa</th>
                                                    <th class="w-[20%] whitespace-nowrap px-4 py-2 font-medium text-blue-600">
                                                        <button type="button" @click="addPublisher">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="items-center divide-y divide-gray-200">
                                                <template v-if="form.field.publisher.length > 0">
                                                    <tr v-for="(publisher, key) in form.field.publisher" :key="key">
                                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                                            <label :for="'publisher_' + (key + 1)" class="relative block overflow-hidden border-b border-gray-200 bg-transparent pt-3 focus-within:border-blue-600">
                                                                <input type="text" :id="'publisher_' + (key + 1)" :placeholder="'Penerbit ' + (key + 1)" class="peer h-8 w-full border-none bg-transparent p-0 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm" :name="'publisher_' + (key + 1)" v-model="publisher.name" />

                                                                <span class="absolute start-0 top-2 -translate-y-1/2 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs"> Penerbit {{ key + 1 }} </span>
                                                            </label>
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-center text-red-600">
                                                            <button type="button" @click="delPublisher(publisher)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                                                    />
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td colspan="2" class="whitespace-nowrap px-4 py-2 text-center text-gray-700">
                                                            <div>Klik tombol plus untuk menambahkan</div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-span-6" :class="form.field.supplier || form.field.supp_distributor ? '' : 'hidden'">
                                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                            <thead class="justify-between text-center">
                                                <tr>
                                                    <th class="w-[80%] whitespace-nowrap px-4 py-2 font-bold text-gray-700">Kategori Buku</th>
                                                    <th class="w-[20%] whitespace-nowrap px-4 py-2 font-medium text-blue-600">
                                                        <button type="button" @click="getKategori">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="items-center divide-y divide-gray-200">
                                                <template v-if="form.field.category.length > 0">
                                                    <tr v-for="(category, key) in form.field.category" :key="key">
                                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ category.desc }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-center text-red-600">
                                                            <button type="button" @click="delKategori(category)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                                                    />
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td colspan="2" class="whitespace-nowrap px-4 py-2 text-center text-gray-700">
                                                            <div>Klik tombol plus untuk menambahkan</div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-span-6">
                                    <label for="npwp" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.npwp ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="npwp" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="No. NPWP" name="npwp" v-model="form.field.npwp" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">No. NPWP</span>
                                    </label>
                                    <ErrorMessage name="npwp" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="account_bank" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.account_bank ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="account_bank" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="No. Rekening" name="account_bank" v-model="form.field.account_bank" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">No. Rekening</span>
                                    </label>
                                    <ErrorMessage name="account_bank" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="account_name" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.account_name ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="account_name" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Rekening" name="account_name" v-model="form.field.account_name" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Rekening</span>
                                    </label>
                                    <ErrorMessage name="account_name" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="bank" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.bank ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="bank" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Nama Bank" name="bank" v-model="form.field.bank" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Nama Bank</span>
                                    </label>
                                    <ErrorMessage name="bank" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="bank_city" class="relative block rounded-md border shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600" :class="errors.bank_city ? 'border-red-500' : 'border-gray-200'">
                                        <Field type="text" id="bank_city" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" placeholder="Kota Bank" name="bank_city" v-model="form.field.bank_city" />

                                        <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">Kota Bank</span>
                                    </label>
                                    <ErrorMessage name="bank_city" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6">
                                    <label for="agreement" class="flex gap-4">
                                        <input type="checkbox" id="agreement" name="agreement" v-model="form.field.agreement" class="size-5 rounded-md border-gray-200 bg-white shadow-sm" />

                                        <span class="text-sm text-red-700 underline"> Saya menyatakan bahwa semua data telah diisi dengan data yang benar dan apabila ada perubahan saya akan mengisi ulang formulir ini sebagai data perbaikan. Saya bertanggungjawab terhadap kebenaran data ini, dan dokumen akan otomatis terbentuk tanda tangan elektronik atas dasar persetujuan saya. </span>
                                    </label>
                                    <ErrorMessage name="agreement" class="mt-1 block text-sm text-red-600 dark:text-red-500" />
                                </div>

                                <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                                    <button class="inline-block shrink-0 rounded-md border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500 disabled:opacity-75" :disabled="form.field.agreement ? false : true">Daftar</button>

                                    <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                                        Sudah punya akun?
                                        <a href="/" class="text-gray-700 underline">Masuk</a>.
                                    </p>
                                </div>
                            </template>
                        </form>
                    </VeeForm>
                </div>
            </main>
        </div>
    </section>

    <!-- modal -->
    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" @close="(open = false), (search = '')">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Kategori Buku</DialogTitle>
                                        <div class="relative mt-2">
                                            <label for="Search" class="sr-only"> Search </label>

                                            <input type="text" id="Search" v-model="search" placeholder="Search for..." class="w-full rounded-md border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm" />

                                            <span class="absolute inset-y-0 end-0 grid w-10 place-content-center">
                                                <button type="button" class="text-gray-600 hover:text-gray-700">
                                                    <span class="sr-only">Search</span>

                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="mt-2 h-[62vh] overflow-scroll">
                                            <div class="mb-0 flex items-center" v-for="(category, i) in categoryView">
                                                <input type="checkbox" class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600" v-model="form.field.category" :id="'category_' + i" :name="'category_' + i" :value="{ id: category.id, desc: category.name }" />
                                                <label :for="'category_' + i" class="ms-2 text-lg font-medium text-gray-900 dark:text-gray-300">{{ category.name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="(open = false), (search = '')" ref="cancelButtonRef">Close</button>
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
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

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
        ExclamationTriangleIcon,
    },

    data() {
        return {
            open: false,
            search: '',

            option: {
                province: [],
                regency: [],
                district: [],
                subdistrict: [],
                category: [],
            },

            form: {
                field: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    country: '',
                    province: '',
                    regency: '',
                    district: '',
                    subdistrict: '',
                    postal_code: '',
                    address: '',
                    telephone: '',
                    handphone: '',
                    director: '',
                    position: '',
                    handphone_director: '',
                    person_in_charge: '',
                    handphone_person_in_charge: '',
                    imprint: [],
                    publisher: [],
                    category: [],
                    npwp: '',
                    account_bank: '',
                    bank: '',
                    account_name: '',
                    bank_city: '',
                    supplier: true,
                    distributor: false,
                    supp_distributor: false,
                    agreement: false,
                },
            },
        }
    },

    mounted() {
        let _row = this
        document.querySelectorAll('.single-checkbox').forEach((checkbox) => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    document.querySelectorAll('.single-checkbox').forEach((cb) => {
                        if (cb !== this) {
                            cb.checked = false
                            _row.form.field[cb.id] = false
                        }
                    })
                }
            })
        })
    },

    methods: {
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

        getKategori() {
            this.open = true

            window.axios
                .get('/options/x0y0z0', {
                    params: {
                        param: 'kategori-mst',
                    },
                })
                .then((response) => {
                    this.option.category = response.data
                })
        },
        delKategori(index) {
            this.form.field.category.splice(this.form.field.category.indexOf(index), 1)
        },

        addImprint() {
            this.form.field.imprint.push({ name: '' })
        },
        delImprint(index) {
            this.form.field.imprint.splice(this.form.field.imprint.indexOf(index), 1)
        },

        addPublisher() {
            this.form.field.publisher.push({ name: '' })
        },
        delPublisher(index) {
            this.form.field.publisher.splice(this.form.field.publisher.indexOf(index), 1)
        },

        async submit() {
            let loader = this.$loading.show()
            try {
                const response = await window.axios.post('/register', this.form.field)
                this.$notyf.success(response.data.message || 'Register successful!')
                window.location.href = '/'
                loader.hide()
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

    computed: {
        categoryView() {
            if (this.search && this.search != '') {
                return this.option.category.filter((row) => {
                    return row.id.toLowerCase().includes(this.search.toLowerCase()) || row.name.toLowerCase().includes(this.search.toLowerCase())
                })
            }
            return this.option.category
        },
    },
}
</script>
