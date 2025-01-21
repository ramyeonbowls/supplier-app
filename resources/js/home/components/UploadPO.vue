<template>
    <div class="w-100 h-100 mx-auto flex flex-col overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <template v-if="form.data">
                        <!-- <button class="group relative inline-flex items-center overflow-hidden rounded bg-cyan-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-cyan-500" @click.prevent="submit">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Kirim ke Supplier </span>
                        </button> -->
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click="onUpload">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Upload PO </span>
                        </button>
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click="exportTpl">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Download Template </span>
                        </button>
                    </template>
                    <template v-if="form.upload">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click.prevent="submit">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Submit </span>
                        </button>
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-rose-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-rose-500" @click="cancel">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Cancel </span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
        <div class="flex flex-grow flex-col p-6">
            <div class="tabs-container">
                <div class="tabs flex w-48 gap-2">
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.data ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Data</button>
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.upload ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Form</button>
                </div>

                <div class="tab-content mt-4 min-h-[23.75rem] flex-grow overflow-auto">
                    <div class="tab-panel" :class="form.data ? '' : 'hidden'">
                        <div class="flex items-center justify-start gap-2 py-3">
                            <div class="relative">
                                <input ref="datepicker" type="text" v-model="filters.date" placeholder="Select date" class="w-full rounded-md border-gray-200 py-2 pe-10 shadow-sm sm:text-sm" readonly />
                            </div>
                            <div class="relative">
                                <select name="client" id="client" v-model="filters.client" class="w-full rounded-md border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm">
                                    <option value="">Filter Client</option>
                                    <option v-for="(value, key) in options.client" :key="key" :value="value.id">{{ value.name }}</option>
                                </select>
                            </div>
                            <div class="relative">
                                <button class="group relative inline-flex items-center overflow-hidden rounded bg-sky-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-sky-500" @click="getData">
                                    <span class="absolute -start-full transition-all group-hover:start-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                                        </svg>
                                    </span>

                                    <span class="text-sm font-medium transition-all group-hover:ms-4"> Tampilkan </span>
                                </button>
                            </div>
                        </div>

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
                                                <!-- <th class="cursor-pointer border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">
                                                    <input type="checkbox" id="selectAll" @change="selectAll" v-model="isAllChecked" class="size-5 rounded border-gray-300" />
                                                </th> -->
                                                <th v-for="header in headers" @click="sortBy(header)" class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">
                                                    {{ header.label }}
                                                </th>
                                                <th class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">ACTION</th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-gray-200">
                                            <template v-if="paginatedData.length > 0">
                                                <tr v-for="row in paginatedData" class="even:bg-gray-50 hover:bg-gray-100">
                                                    <!-- <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                        <input type="checkbox" v-model="selectedRows" :value="row" class="size-5 rounded border-gray-300" />
                                                    </td> -->
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
                                                            <p class="whitespace-nowrap text-sm">Approved</p>
                                                        </span>
                                                        <span v-if="row['status'] == '3'" class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                            </svg>
                                                            <p class="whitespace-nowrap text-sm">Dikirim ke Supplier</p>
                                                        </span>
                                                        <span v-if="row['status'] == '4'" class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                            </svg>
                                                            <p class="whitespace-nowrap text-sm">Lunas</p>
                                                        </span>
                                                    </td>
                                                    <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2 text-right">{{ row['po_amount'] }}</td>
                                                    <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2 text-right">{{ row['po_nett'] }}</td>
                                                    <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2 text-right">{{ row['persentase_supplier'] }} %</td>
                                                    <td class="flex justify-start gap-2 whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                        <a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" @click="getDetail(row)">Detail</a>
                                                        <a href="javascript:void(0);" class="download-link inline-block rounded border border-emerald-600 bg-emerald-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-600 focus:outline-none focus:ring active:text-emerald-500" @click="getDetailSupplier(row)">Detail Supplier</a>
                                                        <a v-if="row['status'] == '1'" href="javascript:void(0);" class="w-36 text-center download-link inline-block rounded border border-sky-600 bg-sky-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-sky-600 focus:outline-none focus:ring active:text-sky-500" @click="sendSupplier(row, '2')">Approve Client</a>
                                                        <a v-if="row['status'] == '2'" href="javascript:void(0);" class="w-36 text-center download-link inline-block rounded border border-sky-600 bg-sky-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-sky-600 focus:outline-none focus:ring active:text-sky-500" @click="sendSupplier(row, '3')">Approve Supplier</a>
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
                    <div class="tab-panel" :class="form.upload ? '' : 'hidden'">
                        <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                            <form @submit.prevent="handleSubmit($event, submit)">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
                                    <div class="h-32 rounded-md border p-2 font-[sans-serif] shadow-sm">
                                        <file-pond
                                            name="excel"
                                            ref="excel"
                                            label-idle='<div class="flex justify-center gap-1 items-center"><div class="p-3 items-center"><svg class="size-8 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg></div><div>Upload file Excel (.xlsx)...</div></div>'
                                            :allow-multiple="false"
                                            accepted-file-types="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                            label-file-type-not-allowed="Hanya file .xlsx yang diperbolehkan."
                                            file-validate-type-label-expected-types="Memerlukan file Excel (.xlsx)"
                                            max-file-size="300MB"
                                            v-on:init="handleFilePondInit"
                                            credits="false"
                                            v-on:updatefiles="onChangeExcel"
                                            style-class="custom-filepond"
                                        />
                                        <dt class="text-xs font-medium text-slate-500"><span class="text-red-500">*</span> Hanya file (<span class="text-red-500">.xlsx</span>) yang diperbolehkan.</dt>
                                    </div>
                                </div>
                            </form>
                        </VeeForm>
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
                                        <div class="mt-2 h-[60vh] w-[38vh] overflow-scroll p-1 sm:h-[48vh] sm:w-[190vh]">
                                            <div class="overflow-x-auto">
                                                <table class="divide-y-2 divide-gray-200 bg-white text-sm">
                                                    <thead class="ltr:text-left rtl:text-right">
                                                        <tr>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">COVER</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">JUDUL</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">ISBN / EISBN</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">PENULIS</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">PENERBIT</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">QTY</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">HARGA</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">NETTO ({{ header_detail.persentase_supplier }}%)</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">TOTAL HARGA</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">TOTAL NETTO</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="divide-y divide-gray-200">
                                                        <tr v-for="(row, key) in detail" :key="key" class="odd:bg-gray-50">
                                                            <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                                                <img :src="row.cover" class="thumbnail h-13 w-10 rounded-sm" alt="covers" />
                                                            </td>
                                                            <td class="px-4 py-2 text-left text-gray-700">{{ row.book_name }}</td>
                                                            <td class="px-4 py-2 text-left text-gray-700">{{ row.isbn }}</td>
                                                            <td class="px-4 py-2 text-left text-gray-700">{{ row.writer }}</td>
                                                            <td class="px-4 py-2 text-left text-gray-700">{{ row.publisher_desc }}</td>
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
                                        <div class="mt-2 w-[38vh] sm:w-[190vh] sm:mt-4 lg:flex lg:items-start lg:gap-5">
                                            <div class="mt-2 grow sm:mt-4 lg:mt-0">
                                                <div class="space-y-2 rounded-lg border border-gray-100 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                                                    <div class="grid grid-cols-1 gap-1 lg:grid-cols-3 lg:gap-4">
                                                        <div></div>
                                                        <div></div>
                                                        <div>
                                                            <div class="space-y-1">
                                                                <dl class="flex items-center justify-between gap-4">
                                                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Subtotal</dt>
                                                                    <dd class="text-base font-medium text-gray-900 dark:text-white">{{ header_detail.po_amount }}</dd>
                                                                </dl>

                                                                <dl class="flex items-center justify-between gap-4">
                                                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Supplier %</dt>
                                                                    <dd class="text-base font-medium text-gray-900">{{ header_detail.persentase_supplier }}</dd>
                                                                </dl>
                                                            </div>

                                                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                                                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                                                <dd class="text-base font-bold text-gray-900 dark:text-white">{{ header_detail.po_nett }}</dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:justify-end sm:gap-2 sm:px-6">
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open = false" ref="cancelButtonRef">Close</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <TransitionRoot as="template" :show="openSupplier">
        <Dialog class="relative z-50" @close="openSupplier = false">
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
                                        <div class="mt-2 h-[60vh] w-[38vh] overflow-scroll p-1 sm:h-[48vh] sm:w-[190vh]">
                                            <div class="overflow-x-auto">
                                                <table class="divide-y-2 divide-gray-200 bg-white text-sm">
                                                    <thead class="ltr:text-left rtl:text-right">
                                                        <tr>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">SUPPLIER</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">NAMA INSTANSI</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">NO. PO</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">TANGGAL PO</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">GROSS PO</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">NETTO PO</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">PERSENTASE SUPPLIER</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="divide-y divide-gray-200">
                                                        <tr v-for="(row, key) in detailSupplier" :key="key" class="odd:bg-gray-50">
                                                            <td class="px-4 py-2 text-left text-gray-700">{{ row.supplier_name }}</td>
                                                            <td class="px-4 py-2 text-left text-gray-700">{{ row.client_name }}</td>
                                                            <td class="px-4 py-2 text-left text-gray-700">{{ row.po_number }}</td>
                                                            <td class="px-4 py-2 text-left text-gray-700">{{ row.po_date }}</td>
                                                            <td class="whitespace-nowrap px-4 py-2 text-right text-gray-700">{{ row.po_amount }}</td>
                                                            <td class="whitespace-nowrap px-4 py-2 text-right text-gray-700">{{ row.po_nett }}</td>
                                                            <td class="whitespace-nowrap px-4 py-2 text-right text-gray-700">{{ row.persentase_supplier }} %</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:justify-end sm:gap-2 sm:px-6">
                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-400 sm:ml-3 sm:w-auto" @click="exportTplDetail">Cetak Laporan</button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="openSupplier = false" ref="cancelButtonRef">Close</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon, InformationCircleIcon } from '@heroicons/vue/24/outline'

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
            openSupplier: false,
            headers: [
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
            detailSupplier: [],
            header_detailSupplier: [],
            searchQuery: '',
            rowsPerPage: 10,
            currentPage: 1,
            sortKey: '',
            sortAsc: true,
            perPageOptions: [5, 10, 15, 20, 25, 50],

            isAllChecked: false,
            selectedRows: [],

            options: {
                client: [],
            },

            filters: {
                date: '',
                client: '',
            },

            form: {
                data: true,
                upload: false,

                field: {
                    excel: '',
                },

                submitted: false,
            },
        }
    },

    mounted() {
        this.getData()
        this.getClient()

        flatpickr(this.$refs.datepicker, {
            mode: 'range',
            dateFormat: 'Y-m-d',
        })
    },

    methods: {
        getData() {
            this.data = []

            let loader = this.$loading.show()
            window.axios
                .get('/transactions/po-upload', {
                    params: {
                        date: this.filters.date,
                        client: this.filters.client,
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

        getClient() {
            this.options.client = []

            let loader = this.$loading.show()
            window.axios
                .get('/transactions/po-upload/x0y0z0', {
                    params: {
                        param: 'client-mst',
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.options.client = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getDetail(row) {
            this.detail = []
            this.header_detail = []

            window.axios
                .get('/transactions/po-upload/x0y0z0', {
                    params: {
                        param: 'detail-po',
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

        getDetailSupplier(row) {
            this.detailSupplier = []
            this.header_detailSupplier = []

            window.axios
                .get('/transactions/po-upload/x0y0z0', {
                    params: {
                        param: 'detail-po-supplier',
                        client: row.client_id,
                        ponumber: row.po_number,
                        podate: row.po_date,
                    },
                })
                .then((response) => {
                    this.detailSupplier = response.data
                    this.header_detailSupplier = row
                    this.openSupplier = true
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        clearForm() {
            this.form.submitted = false
            this.form.field.excel = ''
            this.$refs.excel.removeFiles()
        },

        onUpload() {
            this.form.data = false
            this.form.upload = true

            this.clearForm()
        },

        cancel() {
            this.form.data = true
            this.form.upload = false

            this.clearForm()
            this.$refs.form.resetForm()
            this.getData()
        },

        handleFilePondInit: function () {},

        onChangeExcel() {
            const files = this.$refs.excel.getFiles()
            if (files.length > 0) {
                this.form.field.excel = files[0].file
            } else {
                this.form.field.excel = null
            }
        },

        submit() {
            if (!this.form.submitted) {
                this.form.submitted = true

                this.$refs.form.validate().then((result) => {
                    if (result.valid) {
                        this.form.submitted = false

                        let loader = this.$loading.show()

                        let form_data = new FormData()
                        form_data.append('file_master', this.form.field.excel)

                        window.axios
                            .post('/transactions/po-upload-excel/upload?menu=' + this.$route.name, form_data)
                            .then((response) => {
                                loader.hide()

                                if (response.data.message.length > 0) {
                                    response.data.message.forEach((element) => {
                                        this.$notyf.success(element)
                                    })
                                }

                                this.cancel()
                            })
                            .catch((e) => {
                                this.form.submitted = false
                                this.clearForm()
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

        sendSupplier(row, status) {
            if (!this.form.submitted) {
                this.form.submitted = true
                let loader = this.$loading.show()

                window.axios
                    .put('/transactions/po-upload/' + status + '?menu=' + this.$route.name, row)
                    .then((response) => {
                        loader.hide()
                        this.form.submitted = false
                        this.cancel()
                    })
                    .catch((e) => {
                        this.form.submitted = false
                        this.clearForm()
                        loader.hide()

                        if (e.response && e.response.data && e.response.data.message) {
                            this.$notyf.error(e.response.data.message)
                        } else {
                            this.$notyf.error(e.message || 'An error occurred.')
                        }
                    })
            }
        },

        async exportTpl(filename) {
            await window
                .axios({
                    url: '/transactions/po-upload-excel/export-tpl',
                    method: 'POST',
                    responseType: 'blob',
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'upload_data_po.xlsx')
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
        },

        async exportTplDetail(filename) {
            await window
                .axios({
                    url: '/transactions/po-upload-excel/export-dtl-tpl',
                    method: 'POST',
                    responseType: 'blob',
                    data: {
                        data: this.header_detailSupplier,
                    },
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'laporan_po_supplier.xlsx')
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((e) => {
                    console.log(e.response.data)
                })
        },

        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page
                this.updateIsAllChecked()
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

        selectAll() {
            const pageIds = this.paginatedData.map((item) => item)
            if (this.isAllChecked) {
                this.selectedRows = [...new Set([...this.selectedRows, ...pageIds])]
            } else {
                this.selectedRows = this.selectedRows.filter((id) => !pageIds.includes(id))
            }
        },

        updateIsAllChecked() {
            const pageIds = this.paginatedData.map((item) => item)
            this.isAllChecked = pageIds.every((id) => this.selectedRows.includes(id))
        },
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

    watch: {
        rowsPerPage() {
            this.currentPage = 1
        },

        searchQuery() {
            this.currentPage = 1
        },

        filteredData() {
            if (this.currentPage > this.totalPages) {
                this.currentPage = this.totalPages
            }
        },
    },
}
</script>
