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
        <div class="flex flex-grow flex-col p-6">
            <div class="tabs-container">
                <div class="tabs flex w-48 gap-2">
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.data ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Data</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.encrypt ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Enkripsi Buku</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.update ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Informasi Penerbit & Kategori</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.upload ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Upload Informasi Buku</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.review ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Draft Review</button>
                </div>

                <div class="tab-content mt-4 min-h-[23.75rem] flex-grow overflow-auto">
                    <div class="relative mb-4 flex gap-8">
                        <details id="filterDetails" class="group [&_summary::-webkit-details-marker]:hidden">
                            <summary class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900 transition hover:border-gray-600">
                                <span class="text-sm font-medium"> Filter Status </span>

                                <span class="transition group-open:-rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </summary>

                            <div class="z-20 group-open:absolute group-open:start-0 group-open:top-auto group-open:mt-2">
                                <div class="w-96 rounded border border-gray-200 bg-white">
                                    <header class="flex items-center justify-between p-4">
                                        <span class="text-sm text-gray-700"> {{ selected.length }} Selected </span>

                                        <button type="button" class="text-sm text-gray-900 underline underline-offset-4" @click="resetFilter">Reset</button>
                                    </header>

                                    <ul class="h-[35vh] space-y-1 overflow-scroll border-t border-gray-200 p-4">
                                        <li>
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="draft" name="draft" value="1" v-model="selected" class="size-5 rounded border-gray-300" />
                                                <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                    <p class="whitespace-nowrap text-sm">Draft</p>
                                                </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="review" name="review" value="2" v-model="selected" class="size-5 rounded border-gray-300" />
                                                <span class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                    <p class="whitespace-nowrap text-sm">Review</p>
                                                </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="publish" name="publish" value="3" v-model="selected" class="size-5 rounded border-gray-300" />
                                                <span class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                    <p class="whitespace-nowrap text-sm">Publish</p>
                                                </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="publish_pending" name="publish_pending" value="4" v-model="selected" class="size-5 rounded border-gray-300" />
                                                <span class="inline-flex items-center justify-center rounded-full bg-lime-100 px-2.5 py-0.5 text-lime-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                    <p class="whitespace-nowrap text-sm">Publish pending</p>
                                                </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="reject" name="reject" value="5" v-model="selected" class="size-5 rounded border-gray-300" />
                                                <span class="inline-flex items-center justify-center rounded-full bg-rose-100 px-2.5 py-0.5 text-rose-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                    <p class="whitespace-nowrap text-sm">Reject</p>
                                                </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="ditarik" name="ditarik" value="6" v-model="selected" class="size-5 rounded border-gray-300" />
                                                <span class="inline-flex items-center justify-center rounded-full bg-stone-100 px-2.5 py-0.5 text-stone-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                    <p class="whitespace-nowrap text-sm">Ditarik</p>
                                                </span>
                                            </label>
                                        </li>
                                    </ul>

                                    <footer class="flex items-center justify-end border-t border-gray-200 p-4">
                                        <button type="button" class="text-sm text-gray-900 underline underline-offset-4" @click="getData">Tampilkan</button>
                                    </footer>
                                </div>
                            </div>
                        </details>
                    </div>

                    <div class="tab-panel" :class="form.data ? '' : 'hidden'">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="relative">
                                <input type="text" id="search" v-model="searchQuery" placeholder="Search for..." class="w-full rounded-md border-gray-200 py-2 pe-10 shadow-sm sm:text-sm" />
                            </div>

                            <div class="flex w-[20rem] items-center justify-end gap-2">
                                <label for="HeadlineAct" class="block text-sm font-medium text-gray-900"> Rows per page : </label>
                                <select v-model="rowsPerPage" class="w-1/4 rounded-md border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm">
                                    <option v-for="option in perPageOptions" :key="option" :value="option">
                                        {{ option }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <div class="rounded-lg border border-gray-300">
                                <div class="overflow-x-auto rounded-t-lg">
                                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                        <thead class="bg-slate-300 text-left">
                                            <tr>
                                                <th class="cursor-pointer border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">
                                                    <input type="checkbox" id="selectAll" :checked="isAllSelected" @change="toggleSelectAll" class="size-5 rounded border-gray-300" />
                                                </th>
                                                <th v-for="(header, index) in headers" :key="index" class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">
                                                    {{ header.label }}
                                                    <template v-if="sortKey === header.key">
                                                        <span v-if="sortAsc" class="inline-flex items-center">
                                                            <svg class="-me-0.5 ms-1 size-3.5 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500" d="m7 15 5 5 5-5"></path>
                                                                <path class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500" d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </span>
                                                        <span v-else class="inline-flex items-center">
                                                            <svg class="-me-0.5 ms-1 size-3.5 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500" d="m7 15 5 5 5-5"></path>
                                                                <path class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500" d="m7 9 5-5 5 5"></path>
                                                            </svg>
                                                        </span>
                                                    </template>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-gray-200">
                                            <template v-if="paginatedData.length > 0">
                                                <tr v-for="row in paginatedData" :key="row.book_id" class="even:bg-gray-50 hover:bg-gray-100">
                                                    <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                        <input v-if="row.status == 'Draft'" type="checkbox" v-model="selectedRows" :value="row.book_id" class="size-5 rounded border-gray-300" />
                                                    </td>
                                                    <td v-for="header in headers" :key="header.key" class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                        <template v-if="header.key == 'path_cover'">
                                                            <img :src="row[header.key]" class="thumbnail rounded-sm" alt="covers" @click="showImages(row[header.key])" />
                                                        </template>
                                                        <template v-else-if="header.key == 'filename'">
                                                            <a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" @click="downloadFile('books', row[header.key])">Download file enkripsi</a>
                                                        </template>
                                                        <template v-else-if="header.key == 'status'">
                                                            <span v-if="row[header.key] == '1'" class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                </svg>
                                                                <p class="whitespace-nowrap text-sm">Draft</p>
                                                            </span>
                                                            <span v-else-if="row[header.key] == '2'" class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                </svg>
                                                                <p class="whitespace-nowrap text-sm">Review</p>
                                                            </span>
                                                            <span v-else-if="row[header.key] == '3'" class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                </svg>
                                                                <p class="whitespace-nowrap text-sm">Publish</p>
                                                            </span>
                                                            <span v-else-if="row[header.key] == '4'" class="inline-flex items-center justify-center rounded-full bg-lime-100 px-2.5 py-0.5 text-lime-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                </svg>
                                                                <p class="whitespace-nowrap text-sm">Publish pending</p>
                                                            </span>
                                                            <span v-else-if="row[header.key] == '5'" class="inline-flex items-center justify-center rounded-full bg-rose-100 px-2.5 py-0.5 text-rose-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                </svg>
                                                                <p class="whitespace-nowrap text-sm">Reject</p>
                                                            </span>
                                                            <span v-else-if="row[header.key] == '6'" class="inline-flex items-center justify-center rounded-full bg-stone-100 px-2.5 py-0.5 text-stone-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                </svg>
                                                                <p class="whitespace-nowrap text-sm">Ditarik</p>
                                                            </span>
                                                        </template>
                                                        <template v-else-if="header.key == 'sinopsis'">
                                                            <a href="javascript:void(0)" class="whitespace-nowrap" @click="showSinopsis(row[header.key])">{{ row[header.key].substring(0, 10) + '...' }}</a>
                                                        </template>
                                                        <template v-else>
                                                            {{ row[header.key] }}
                                                        </template>
                                                    </td>
                                                </tr>
                                            </template>
                                            <template v-else>
                                                <tr class="even:bg-gray-50 hover:bg-gray-100">
                                                    <td :colspan="headers.length" class="border-b border-gray-200 px-4 py-2 text-center">No Data to Show !</td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="flex items-center justify-between border-t border-gray-200 px-4 py-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Showing {{ startEntry }} to {{ endEntry }} of {{ filteredData.length }} entries</p>
                                    </div>
                                    <ol class="flex justify-end gap-1 text-xs font-medium">
                                        <li>
                                            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 disabled:opacity-50 rtl:rotate-180">
                                                <span class="sr-only">Prev Page</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </li>

                                        <li v-if="currentPage > 3">
                                            <button @click="goToPage(1)" class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900">1</button>
                                        </li>

                                        <li v-if="currentPage > 4">
                                            <span class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900">...</span>
                                        </li>

                                        <li v-for="page in pagesToShow" :key="page">
                                            <button @click="goToPage(page)" :class="page === currentPage ? 'block size-8 rounded border-blue-600 bg-blue-600 text-center leading-8 text-white' : 'block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900'">
                                                {{ page }}
                                            </button>
                                        </li>

                                        <li v-if="currentPage < totalPages - 3">
                                            <span class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900">...</span>
                                        </li>

                                        <li v-if="currentPage < totalPages - 2">
                                            <button @click="goToPage(totalPages)" class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900">{{ totalPages }}</button>
                                        </li>

                                        <li>
                                            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 disabled:opacity-50 rtl:rotate-180">
                                                <span class="sr-only">Next Page</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
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
                                                <td class="px-4 py-2 text-gray-700"><img :src="file.path_cover" class="thumbnail rounded-sm" :data-image="file.path_cover" alt="covers" @click="showImages(file.path_cover)" /></td>
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
                                            <img :src="file.path_cover" class="thumbnail rounded-sm" :data-image="file.path_cover" alt="covers" @click="showImages(file.path_cover)" />
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
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-red-600">{{ error.row }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.book_id.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.book_id.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.filename.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.filename.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.isbn.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.isbn.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.eisbn.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.eisbn.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.title.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.title.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.writer.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.writer.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.size.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.size.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.year.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.year.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.volume.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.volume.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.edition.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.edition.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.page.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.page.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.sinopsis.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.sinopsis.split('|')[1] ? error.sinopsis.split('|')[1].substring(0, 10) : '' }} ...</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.sellprice.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.sellprice.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.rentprice.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.rentprice.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.retailprice.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.retailprice.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.city.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.city.split('|')[1] }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium" :class="error.age.split('|')[0] == 'error' ? 'text-red-600' : 'text-gray-900'">{{ error.age.split('|')[1] }}</td>
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
import { Form as VeeForm, Field, ErrorMessage, defineRule } from 'vee-validate'
import { required } from '@vee-validate/rules'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon, InformationCircleIcon } from '@heroicons/vue/24/outline'

defineRule('required', required)

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
            selected: [],

            headers: [
                { label: 'cover', key: 'path_cover' },
                { label: 'judul', key: 'title' },
                { label: 'file', key: 'filename' },
                { label: 'ukuran', key: 'file_size' },
                { label: 'status', key: 'status' },
                { label: 'penulis', key: 'writer' },
                { label: 'publisher', key: 'publisher_desc' },
                { label: 'isbn', key: 'isbn' },
                { label: 'eisbn', key: 'eisbn' },
                { label: 'kategori', key: 'category_desc' },
                { label: 'kota', key: 'city' },
                { label: 'tahun', key: 'year' },
                { label: 'edisi', key: 'edition' },
                { label: 'halaman', key: 'page' },
                { label: 'sinopsis', key: 'sinopsis' },
                { label: 'ukuran', key: 'size' },
                { label: 'jilid', key: 'volume' },
                { label: 'umur', key: 'age' },
                { label: 'harga jual', key: 'sellprice' },
                { label: 'harga pinjam', key: 'rentprice' },
                { label: 'harga retail', key: 'retailprice' },
                { label: 'tanggal upload', key: 'createdate' },
            ],
            data: [],
            searchQuery: '',
            rowsPerPage: 20,
            currentPage: 1,
            sortKey: '',
            sortAsc: true,
            perPageOptions: [20, 30, 40, 50],

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
    },

    methods: {
        hideFilter() {
            document.getElementById('filterDetails').removeAttribute('open')
        },

        resetFilter() {
            this.selected = []
        },

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

        toggleSelectAll() {
            if (this.isAllSelected) {
                this.selectedRows = []
            } else {
                this.selectedRows = this.paginatedData.map((row) => row.book_id)
            }
        },

        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page
            }
        },

        sortBy(header) {
            if (this.sortKey === header.key) {
                this.sortAsc = !this.sortAsc
            } else {
                this.sortKey = header.key
                this.sortAsc = true
            }
        },

        getData() {
            this.data = []

            this.hideFilter()

            let loader = this.$loading.show()
            window.axios
                .get('/upload/encrypt-books', {
                    params: {
                        status: this.selected,
                    },
                })
                .then((response) => {
                    this.data = response.data.data

                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
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
                                    if (response.data.error.length > 0) {
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
                    form_data.append('data', JSON.stringify(this.form.field.data_upl))

                    window.axios
                        .post('/upload/encrypt-books-excel/upload?menufn=' + this.$route.name, form_data, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            },
                        })
                        .then((response) => {
                            this.form.submit_count = 0
                            this.form.field.file_excel = null
                            this.$refs.file_excel.value = ''
                            this.encryptReview()
                            loader.hide()

                            this.$notyf.success(response.data.message)
                        })
                        .catch((e) => {
                            this.form.submit_count = 0
                            this.form.field.file_excel = null
                            this.$refs.file_excel.value = ''
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
                    method: 'POST',
                    responseType: 'blob',
                    data: {
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

    computed: {
        isAllSelected() {
            return this.paginatedData.length > 0 && this.paginatedData.every((row) => this.selectedRows.includes(row.book_id))
        },

        filteredData() {
            let data = this.data

            if (this.searchQuery) {
                data = data.filter((item) => {
                    return item.isbn.toLowerCase().includes(this.searchQuery.toLowerCase()) || item.eisbn.toLowerCase().includes(this.searchQuery.toLowerCase()) || item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) || item.writer.toLowerCase().includes(this.searchQuery.toLowerCase())
                })
            }

            if (this.sortKey) {
                data.sort((a, b) => {
                    const result = a[this.sortKey] > b[this.sortKey] ? 1 : -1
                    return this.sortAsc ? result : -result
                })
            }

            return data
        },

        paginatedData() {
            const start = (this.currentPage - 1) * this.rowsPerPage
            const end = start + this.rowsPerPage
            return this.filteredData.slice(start, end)
        },

        totalPages() {
            return Math.ceil(this.filteredData.length / this.rowsPerPage) || 1
        },

        pagesToShow() {
            const range = []
            for (let i = Math.max(1, this.currentPage - 1); i <= Math.min(this.totalPages, this.currentPage + 1); i++) {
                range.push(i)
            }
            return range
        },

        startEntry() {
            return (this.currentPage - 1) * this.rowsPerPage + 1
        },

        endEntry() {
            return Math.min(this.currentPage * this.rowsPerPage, this.filteredData.length)
        },
    },

    watch: {
        rowsPerPage() {
            this.currentPage = 1
            this.currentPage = Math.min(this.currentPage, this.totalPages)
        },

        searchQuery() {
            this.currentPage = 1
        },

        filteredData() {
            this.currentPage = Math.min(this.currentPage, this.totalPages)
        },
    },
}
</script>
