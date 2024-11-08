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
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-teal-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-teal-500" @click="selectedData">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Lengkapi Data Buku </span>
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
                        <template v-if="form.cancel">
                            <button class="group relative inline-flex items-center overflow-hidden rounded bg-red-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click="cancelUpdateData">
                                <span class="absolute -start-full transition-all group-hover:start-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                                    </svg>
                                </span>

                                <span class="text-sm font-medium transition-all group-hover:ms-4"> Kembali </span>
                            </button>
                        </template>
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

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Ajukan Buku </span>
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
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.update ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Informasi Penerbit & Kategori</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.upload ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Upload Informasi Buku</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.review ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Draft Review</button>
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
                                        <p class="mt-2 text-xs text-gray-400">.Zip yang di Izinkan. Ukuran maksimal file Zip 300mb & Setiap file pdf maksimal 20mb.</p>
                                    </div>
                                </div>
                            </form>
                        </VeeForm>
                    </div>
                    <div class="tab-panel" :class="form.update ? '' : 'hidden'">
                        <VeeForm ref="form_update" v-slot="{ handleSubmit }" as="div">
                            <form @submit.prevent="handleSubmit($event, submitUpdate)">
                                <div class="mt-5 overflow-x-auto rounded-lg border border-gray-200" :class="form.export ? 'hidden' : ''">
                                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                        <thead class="text-left">
                                            <tr>
                                                <th class="w-1/6 px-4 py-2 font-semibold text-gray-900">COVER</th>
                                                <th class="w-1/12 px-4 py-2 font-semibold text-gray-900">BUKU ID</th>
                                                <th class="w-1/6 px-4 py-2 font-semibold text-gray-900">NAMA FILE</th>
                                                <th class="w-1/6 px-4 py-2 font-semibold text-gray-900">NAMA COVER</th>
                                                <th class="w-1/6 whitespace-nowrap px-4 py-2 font-semibold text-gray-900">
                                                    <select name="category_all" id="category_all" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" @change="changeCategory">
                                                        <option value="">Pilih Kategori Buku</option>
                                                        <option v-for="(value, key) in options.category" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </select>
                                                </th>
                                                <th class="w-1/6 px-4 py-2 font-semibold text-gray-900">
                                                    <select name="publisher_all" id="publisher_all" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" @change="changePublisher">
                                                        <option value="">Pilih Penerbit</option>
                                                        <option v-for="(value, key) in options.publisher" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </select>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-gray-200">
                                            <tr v-for="(file, key) in form.field.data_upl" :key="key">
                                                <td class="px-4 py-2 text-gray-700"><img :src="file.path_cover" class="h-[70%] w-[70%] rounded-sm shadow-md" :data-image="file.path_cover" alt="covers" @click="showImages(file.path_cover)" /></td>
                                                <td class="text-wrap px-4 py-2 text-gray-700">{{ file.book_id }}</td>
                                                <td class="px-4 py-2 text-gray-700">{{ file.filename }}</td>
                                                <td class="px-4 py-2 text-gray-700">{{ file.cover }}</td>
                                                <td class="px-4 py-2 text-gray-700">
                                                    <Field as="select" :rules="validateCategory" :name="'category' + key" :id="'category' + key" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" v-model="file.category_id">
                                                        <option value="">Pilih Kategori Buku</option>
                                                        <option v-for="(value, key) in options.category" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </Field>
                                                    <ErrorMessage :name="'category' + key" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                                </td>
                                                <td class="px-4 py-2 text-gray-700">
                                                    <Field as="select" :rules="validatePublisher" :name="'publisher' + key" :id="'publisher' + key" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" v-model="file.publisher_id">
                                                        <option value="">Pilih Penerbit</option>
                                                        <option v-for="(value, key) in options.publisher" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </Field>
                                                    <ErrorMessage :name="'publisher' + key" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </VeeForm>
                    </div>
                    <div class="tab-panel" :class="form.upload ? '' : 'hidden'">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click.prevent="exportTpl">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Download Excel </span>
                        </button>
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
                                        <th class="px-4 py-2 font-semibold text-gray-900">COVER</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">JUDUL</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">FILE ENKRIPSI</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">STATUS</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">PENULIS</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">PUBLISHER</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">ISBN</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">EISBN</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">KATEGORI</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">KOTA</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">TAHUN</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">EDISI</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">HALAMAN</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">SINOPSIS</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">JILID</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">UKURAN BUKU</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">UMUR</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">HARGA JUAL</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">HARGA PINJAM</th>
                                        <th class="px-4 py-2 font-semibold text-gray-900">HARGA RETAIL</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="(file, key) in form.field.data_view" :key="key">
                                        <td class="px-4 py-2 text-gray-700">
                                            <img :src="file.path_cover" class="h-4/5 w-9/12 rounded-sm shadow-md" :data-image="file.path_cover" alt="covers" @click="showImages(file.path_cover)" />
                                        </td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.title }}</td>
                                        <td class="px-4 py-2 text-gray-700">
                                            <div class="gap-1">
                                                <p class="mb-1 whitespace-nowrap text-sm">{{ file.filename }}</p>
                                                <a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" @click="downloadFile('books', file.filename)">Download file enkripsi</a>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-gray-700">
                                            <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>

                                                <p class="whitespace-nowrap text-sm">Draft</p>
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.writer }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.publisher_desc }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.isbn }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.eisbn }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.category_desc }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.city }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.year }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.edition }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.page }}</td>
                                        <td class="px-4 py-2 text-gray-700">
                                            <a href="javascript:void(0)" class="whitespace-nowrap" @click="showSinopsis(file.sinopsis)">{{ file.sinopsis.substring(0, 10) + '...' }}</a>
                                        </td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.volume }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.size }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.age }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.sellprice }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.rentprice }}</td>
                                        <td class="px-4 py-2 text-gray-700">{{ file.retailprice }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
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

    <TransitionRoot as="template" :show="open_error">
        <Dialog class="relative z-50" @close="open_error = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-slate-900/80 bg-opacity-5 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-left sm:ml-4 sm:mt-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Gagal Upload</DialogTitle>
                                        <div class="mt-2 h-[40vh] w-[100vh] overflow-scroll p-1">
                                            <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Baris</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Buku ID</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">File</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Isbn</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Eisbn</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Judul</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Penulis</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Ukuran Buku</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Tahun</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Jilid</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Edisi</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Halaman</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Sinopsis</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Harga Jual</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Harga Pinjam</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Harga Retail</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Kota</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">Umur</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="divide-y divide-gray-200">
                                                    <tr v-for="(error, key) in form.field.data_error" :key="key">
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.row }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.book_id }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.filename }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.isbn }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.eisbn }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.title }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.writer }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.size }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.year }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.volume }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.edition }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.page }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.sinopsis }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.sellprice }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.rentprice }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.retailprice }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.city }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ error.age }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open_error = false" ref="cancelButtonRef">Close</button>
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
import { DataTable } from 'simple-datatables'
import { Form as VeeForm, Field, ErrorMessage, defineRule } from 'vee-validate'
import { required } from '@vee-validate/rules'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon, InformationCircleIcon } from '@heroicons/vue/24/outline'

defineRule('required', required)

let dataTable
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
        InformationCircleIcon,
    },

    data() {
        return {
            open: false,
            open_sinopsis: false,
            open_error: false,
            image_url: '',
            detail_sinopsis: '',
            selectedRows: [],

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
                cancel: false,

                field: {
                    file_cover: '',
                    file_pdf: '',
                    data_upl: [],
                    data_view: [],
                    data_error: [],
                    file_excel: null,
                },

                submitted: false,
                submit_count: 0,
            },
        }
    },

    mounted() {
        this.getData()

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
                    { text: 'ukuran buku', data: 'size' },
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
                        if (data.split('|')[1] == '1') {
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
                        return '<div class="gap-1">' + '<p class="whitespace-nowrap mb-1 text-sm">' + data + '</p>' + '<a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" data-file="' + data + '">Download file enkripsi</a>' + '</div>'
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
        clearForm() {
            this.form.field.file_cover = ''
            this.form.field.file_pdf = ''
            this.form.field.file_excel = ''
            this.form.field.data_upl = []
            this.form.field.data_view = []
            this.form.field.data_error = []

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

                    this.attachDownloadListeners()
                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },

        attachDownloadListeners() {
            document.querySelectorAll('.download-link').forEach((element) => {
                element.addEventListener('click', (event) => {
                    let file = event.target.closest('a').getAttribute('data-file')
                    this.downloadFile('books', file)
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
                    if (element.checked) {
                        this.pushSelected(file)
                    } else {
                        this.removeSelected(file)
                    }
                })
            })

            document.querySelectorAll('.row-checkbox').forEach((checkbox) => {
                checkbox.checked = false
            })

            /* const headerCheckbox = document.createElement('input')
            headerCheckbox.type = 'checkbox'
            headerCheckbox.id = 'select-all'
            headerCheckbox.classList.add('w-4', 'h-4', 'text-blue-600', 'bg-gray-100', 'border-gray-300', 'rounded', 'focus:ring-blue-500', 'dark:focus:ring-blue-600', 'dark:ring-offset-gray-800', 'dark:focus:ring-offset-gray-800', 'focus:ring-2', 'dark:bg-gray-700', 'dark:border-gray-600')

            headerCheckbox.addEventListener('change', function (e) {
                const checkboxes = document.querySelectorAll('.row-checkbox')
                checkboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked
                })
            })

            const firstHeader = document.querySelector('#default-table thead tr th:first-child')
            firstHeader.innerHTML = ''
            firstHeader.appendChild(headerCheckbox)

            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (!this.checked) {
                        document.getElementById('select-all').checked = false
                    }
                })
            }) */
        },

        showImages(file) {
            this.image_url = file
            this.open = true
        },

        showSinopsis(text) {
            this.detail_sinopsis = text
            this.open_sinopsis = true
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

        getSelectedData(row) {
            window.axios
                .get('/upload/encrypt-books/x0y0z0', {
                    params: {
                        param: 'selected-data',
                        data: row,
                    },
                })
                .then((response) => {
                    this.form.field.data_upl = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        async onChangePdf(e) {
            this.form.field.file_pdf = this.$refs.file_pdf.files[0]
        },

        async onFileExcelUpload(e) {
            this.form.field.file_excel = this.$refs.file_excel.files[0]
        },

        changeCategory(event) {
            const selectedValue = event.target.value
            this.form.field.data_upl.forEach((element) => {
                element.category_id = selectedValue
            })
        },

        validateCategory(value) {
            if (!value) {
                return 'Kategory tidak boleh kosong!'
            }

            return true
        },

        changePublisher(event) {
            const selectedValue = event.target.value
            this.form.field.data_upl.forEach((element) => {
                element.publisher_id = selectedValue
            })
        },

        validatePublisher(value) {
            if (!value) {
                return 'Publisher tidak boleh kosong!'
            }

            return true
        },

        pushSelected(row) {
            this.selectedRows.push(row)
        },
        removeSelected(row) {
            this.selectedRows.splice(this.selectedRows.indexOf(row), 1)
        },

        selectedData() {
            if (this.selectedRows.length > 0) {
                this.encryptUpdateData()
                this.getSelectedData(this.selectedRows)
            } else {
                this.$notyf.error('Tidak ada data yang dipilih!')
            }
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

            this.getCategory()
            this.getPublisher()
            this.getFormat()
        },

        encryptUpdateData() {
            this.form.data = false
            this.form.encrypt = false
            this.form.update = true
            this.form.upload = false
            this.form.review = false
            this.form.cancel = true

            this.getCategory()
            this.getPublisher()
            this.getFormat()
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

        cancelUpdateData() {
            this.form.data = true
            this.form.encrypt = false
            this.form.update = false
            this.form.upload = false
            this.form.review = false
            this.form.cancel = false

            this.selectedRows = []
            this.getData()
            dataTable.refresh()
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
                                    if (response.data.error) {
                                        response.data.error.forEach((element) => {
                                            this.$notyf.error(element)
                                        })
                                    } else {
                                        this.form.field.data_upl = response.data.data
                                        this.$notyf.success('Successfully Encrypt file')
                                        this.encryptUpdate()
                                    }

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

                this.$refs.form_update.validate().then((result) => {
                    if (result.valid) {
                        this.form.submitted = false

                        let loader = this.$loading.show()
                        if (this.form.update) {
                            window.axios
                                .put('/upload/encrypt-books/x0y0z0/?menu=' + this.$route.name, this.form.field.data_upl)
                                .then((response) => {
                                    this.encryptUpload()
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
                        console.log(result)

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

                            this.$notyf.success(response.data.message)
                        })
                        .catch((e) => {
                            this.form.submit_count = 0
                            this.form.field.data_error = []
                            this.form.field.data_error = e.response.data.data
                            loader.hide()
                            this.open_error = true
                            this.$notyf.error(e.response.data.message)
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
