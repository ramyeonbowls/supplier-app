<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="z-50 border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click="exportTpl">
                        <span class="absolute -start-full transition-all group-hover:start-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                            </svg>
                        </span>

                        <span class="text-sm font-medium transition-all group-hover:ms-4"> Cetak Laporan </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="p-6">
            <!-- <div class="relative mb-2 flex gap-8">
                <details id="filterDetails" class="group [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900 transition hover:border-gray-600">
                        <span class="text-sm font-medium"> Filter Tanggal </span>

                        <span class="transition group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </summary>

                    <div class="z-20 group-open:absolute group-open:start-0 group-open:top-auto group-open:mt-2">
                        <div class="w-96 rounded border border-gray-200 bg-white">
                            <div id="date-range-picker" date-rangepicker class="flex items-center p-2">
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-start" name="start" type="text" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" placeholder="Tanggal mulai" readonly />
                                </div>
                                <span class="mx-4 text-gray-500">to</span>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-end" name="end" type="text" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" placeholder="Tanggal berakhir" readonly />
                                </div>
                            </div>

                            <footer class="flex items-center justify-end border-t border-gray-200 p-4">
                                <button type="button" class="text-sm text-gray-900 underline underline-offset-4" @click="getData">Tampilkan</button>
                            </footer>
                        </div>
                    </div>
                </details>
            </div> -->

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
                                    <th v-for="(header, index) in headers" :key="index" @click="sortBy(header)" class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">
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
                                    <th class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">ACTION</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                <template v-if="paginatedData.length > 0">
                                    <tr v-for="row in paginatedData" :key="row.id" class="even:bg-gray-50 hover:bg-gray-100">
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2 font-medium text-gray-900">{{ row['supplier_name'] }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2 font-medium text-gray-900">{{ row['client_name'] }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row['po_number'] }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row['po_date'] }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                            <span v-if="row['po_type'] == '1'" class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
                                                    />
                                                </svg>
                                                <p class="whitespace-nowrap text-sm">Pembelian</p>
                                            </span>
                                            <span v-if="row['po_type'] == '2'" class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
                                                    />
                                                </svg>
                                                <p class="whitespace-nowrap text-sm">Hibah</p>
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                            <span v-if="row['status'] == '1'" class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                </svg>
                                                <p class="whitespace-nowrap text-sm">Open</p>
                                            </span>
                                            <span v-if="row['status'] == '2'" class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                </svg>
                                                <p class="whitespace-nowrap text-sm">On Process</p>
                                            </span>
                                            <span v-if="row['status'] == '3'" class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                </svg>
                                                <p class="whitespace-nowrap text-sm">Finish</p>
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2 text-right">{{ row['po_amount'] }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2 text-right">{{ row['po_nett'] }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2 text-right">{{ row['persentase_supplier'] }} %</td>
                                        <td class="flex justify-center whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                            <a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" @click="getDetail(row)">Detail</a>
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

    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-50" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-slate-900/80 bg-opacity-5 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-[100rem]">
                            <div class="w-[300rem] bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <InformationCircleIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-left sm:ml-4 sm:mt-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Detail PO : {{ header_detail.po_number }}</DialogTitle>
                                        <div class="mt-2 h-[60vh] w-[190vh] overflow-scroll p-1">
                                            <table class="max-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                                <thead class="ltr:text-left rtl:text-right">
                                                    <tr>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Cover</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Judul</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">ISBN / EISBN</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Penulis</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Penerbit</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Qty</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Harga</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Netto ({{ header_detail.persentase_supplier }}%)</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Total Harga</th>
                                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Total Netto</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="divide-y divide-gray-200">
                                                    <tr v-for="(row, key) in detail" :key="key" class="odd:bg-gray-50">
                                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                                            <img :src="row.cover" class="thumbnail rounded-sm" alt="covers" />
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ row.book_name }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ row.isbn }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ row.writer }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ row.publisher_desc }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-right text-gray-700">{{ row.qty }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-right text-gray-700">{{ row.sellprice }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-right text-gray-700">{{ row.nett }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-right text-gray-700">{{ row.total_gross }}</td>
                                                        <td class="whitespace-nowrap px-4 py-2 text-right text-gray-700">{{ row.total_nett }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:justify-end sm:px-6 sm:gap-2">
                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-400 sm:ml-3 sm:w-auto" @click="exportTplDetail">Cetak Laporan</button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open = false" ref="cancelButtonRef">Cancel</button>
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
            headers: [
                { label: 'SUPPLIER', key: 'supplier_name' },
                { label: 'NAMA INSTANSI', key: 'client_name' },
                { label: 'NO. PO', key: 'po_number' },
                { label: 'TANGGAL PO', key: 'po_date' },
                { label: 'TIPE PO', key: 'po_type' },
                { label: 'STATUS', key: 'status' },
                { label: 'GROSS PO', key: 'po_amount' },
                { label: 'NETT PO', key: 'po_nett' },
                { label: 'PERSENTASE SUPPLIER', key: 'persentase_supplier' },
            ],
            data: [],
            detail: [],
            header_detail: [],
            searchQuery: '',
            rowsPerPage: 10,
            currentPage: 1,
            sortKey: '',
            sortAsc: true,
            perPageOptions: [5, 10, 15, 20, 25, 50],
        }
    },

    mounted() {
        this.getData()
    },

    computed: {
        filteredData() {
            let data = [...this.data]

            if (this.searchQuery) {
                data = data.filter((person) => Object.values(person).some((value) => String(value).toLowerCase().includes(this.searchQuery.toLowerCase())))
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

    methods: {
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page
            }
        },

        getData() {
            this.data = []

            let loader = this.$loading.show()
            window.axios
                .get('/report/po-report')
                .then((response) => {
                    this.data = response.data.data
                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },

        getDetail(row) {
            this.detail = []
            this.header_detail = []

            window.axios
                .get('/report/po-report/x0y0z0', {
                    params: {
                        param: 'detail-po',
                        supplier: row.supplier_id,
                        client: row.client_id,
                        ponumber: row.po_number,
                        podate: row.po_date,
                    },
                })
                .then((response) => {
                    this.detail = response.data
                    this.header_detail = row
                    this.open = true
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        sortBy(header) {
            if (this.sortKey === header.key) {
                this.sortAsc = !this.sortAsc
            } else {
                this.sortKey = header.key
                this.sortAsc = true
            }
        },

        async exportTpl(filename) {
            await window
                .axios({
                    url: '/report/po-report-excel/export-tpl',
                    method: 'POST',
                    responseType: 'blob',
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'laporan_penjualan_supplier.xlsx')
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
        },

        async exportTplDetail(filename) {
            console.log(this.header_detail);
            
            await window
                .axios({
                    url: '/report/po-report-excel/export-dtl-tpl',
                    method: 'POST',
                    responseType: 'blob',
                    data: {
                        data: this.header_detail,
                    },
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'laporan_penjualan_supplier_'+ this.header_detail.po_number +'.xlsx')
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
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
