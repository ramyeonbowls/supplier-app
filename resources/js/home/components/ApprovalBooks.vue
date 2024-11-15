<template>
    <div class="w-100 h-100 mx-auto flex flex-col overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click.prevent="submit">
                        <span class="absolute -start-full transition-all group-hover:start-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4"> Publish Buku </span>
                    </button>
                    <button class="group relative inline-flex items-center overflow-hidden rounded bg-rose-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-rose-500" @click.prevent="reject">
                        <span class="absolute -start-full transition-all group-hover:start-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4"> Reject Buku </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex flex-grow flex-col p-6">
            <div class="relative mb-4 flex gap-8">
                <details id="filterDetails" class="group [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900 transition hover:border-gray-600">
                        <span class="text-sm font-medium"> Filter Supplier </span>

                        <span class="transition group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </summary>

                    <div class="z-40 group-open:absolute group-open:start-0 group-open:top-auto group-open:mt-2">
                        <div class="w-96 rounded border border-gray-200 bg-white">
                            <header class="flex items-center justify-between p-4">
                                <span class="text-sm text-gray-700"> {{ selected.length }} Selected </span>

                                <button type="button" class="text-sm text-gray-900 underline underline-offset-4" @click="resetFilter">Reset</button>
                            </header>

                            <ul class="h-[35vh] space-y-1 overflow-scroll border-t border-gray-200 p-4">
                                <li v-for="(supplier, key) in options.supplier" :key="key">
                                    <label :for="supplier.id" class="inline-flex items-center gap-2">
                                        <input type="checkbox" :id="supplier.id" :name="supplier.id" :value="supplier.id" v-model="selected" class="size-5 rounded border-gray-300" />
                                        <span class="text-sm font-medium text-gray-700"> {{ supplier.name }} </span>
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

            <div class="min-h-[380px] flex-grow overflow-auto">
                <div class="z-50 mb-4 flex items-center justify-between">
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
                                                <input v-if="row.status == '2'" type="checkbox" v-model="selectedRows" :value="row.book_id" class="size-5 rounded border-gray-300" />
                                            </td>
                                            <td v-for="header in headers" :key="header.key" class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                <template v-if="header.key == 'path_cover'">
                                                    <img :src="row[header.key]" class="thumbnail rounded-sm" alt="covers" @click="showImages(row[header.key])" />
                                                </template>
                                                <template v-else-if="header.key == 'filename'">
                                                    <a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" @click="downloadFile('books', row[header.key])">Download file enkripsi</a>
                                                </template>
                                                <template v-else-if="header.key == 'sinopsis'">
                                                    <a href="javascript:void(0)" class="whitespace-nowrap" @click="showSinopsis(row[header.key])">{{ row[header.key].substring(0, 10) + '...' }}</a>
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
                                                    <span v-else-if="row[header.key] == '5'" class="inline-flex items-center justify-center rounded-full bg-stone-100 px-2.5 py-0.5 text-stone-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                        </svg>
                                                        <p class="whitespace-nowrap text-sm">Ditarik</p>
                                                    </span>
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
        </div>
    </div>

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
</template>

<script>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon, InformationCircleIcon } from '@heroicons/vue/24/outline'

let dataTable
export default {
    components: {
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
            image_url: '',
            detail_sinopsis: '',

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
                supplier: [],
            },

            selected: [],
            selectedRows: [],
            form: {
                submitted: false,
            },
        }
    },
    mounted() {
        this.getSupplier()
    },

    methods: {
        hideFilter() {
            document.getElementById('filterDetails').removeAttribute('open')
        },

        resetFilter() {
            this.selected = []
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
            let loader = this.$loading.show()

            this.hideFilter()

            window.axios
                .get('/transactions/approval-books', {
                    params: {
                        param: this.selected,
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

        getSupplier() {
            this.options.supplier = []

            window.axios
                .get('/transactions/approval-books/x0y0z0', {
                    params: {
                        param: 'supplier-mst',
                    },
                })
                .then((response) => {
                    this.options.supplier = response.data
                })
                .catch((e) => {
                    console.error(e)
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

        pushSelected(row) {
            this.selectedRows.push(row)
        },

        async viewFile(file) {
            try {
                // Fetch the PDF file as a Blob
                const response = await axios.get('transactions/approval-books-download/view-file', {
                    responseType: 'blob',
                    params: {
                        file: file,
                    },
                })

                // Create a URL for the Blob and open it in a new tab
                const pdfBlob = new Blob([response.data], { type: 'application/pdf' })
                const pdfUrl = URL.createObjectURL(pdfBlob)
                window.open(pdfUrl, '_blank')

                // Optionally, revoke the object URL after some time
                setTimeout(() => URL.revokeObjectURL(pdfUrl), 1000 * 60)
            } catch (error) {
                console.error('Error loading PDF:', error)
            }
        },

        async downloadFile(param, file) {
            await window
                .axios({
                    url: '/transactions/approval-books-download/download-file',
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

        submit() {
            if (!this.form.submitted) {
                this.form.submitted = true

                if (this.selectedRows.length > 0) {
                    let loader = this.$loading.show()
                    window.axios
                        .post('/transactions/approval-books?menu=' + this.$route.name, this.selectedRows)
                        .then((response) => {
                            this.form.submitted = false
                            this.selectedRows = []
                            this.getData()
                            loader.hide()
                            this.$notyf.success('Successfully Publish Books')
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
                } else {
                    this.form.submitted = false
                    this.$notyf.error('Tidak ada data yang dipilih!')
                }
            }
        },

        reject() {
            if (!this.form.submitted) {
                this.form.submitted = true

                if (this.selectedRows.length > 0) {
                    let loader = this.$loading.show()
                    window.axios
                        .put('/transactions/approval-books/x0y0z?menu=' + this.$route.name, this.selectedRows)
                        .then((response) => {
                            this.form.submitted = false
                            this.selectedRows = []
                            this.getData()
                            loader.hide()
                            this.$notyf.success('Successfully Reject Books')
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
                } else {
                    this.form.submitted = false
                    this.$notyf.error('Tidak ada data yang dipilih!')
                }
            }
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
