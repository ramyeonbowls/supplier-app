<template>
    <div class="w-100 h-100 mx-auto flex flex-col overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <template v-if="form.data">
                        <p class="group relative inline-flex items-center overflow-hidden rounded px-8 py-3 text-white"></p>
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
                                                <th v-for="header in headers" @click="sortBy(header)" class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">
                                                    {{ header.label }}
                                                </th>
                                                <th class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-200">ACTION</th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-gray-200">
                                            <template v-if="paginatedData.length > 0">
                                                <tr v-for="row in paginatedData" class="even:bg-gray-50 hover:bg-gray-100">
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
                                                            <p class="whitespace-nowrap text-sm">Approved</p>
                                                        </span>
                                                        <span v-if="row['status'] == '3'" class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                            </svg>
                                                            <p class="whitespace-nowrap text-sm">Belum Lunas</p>
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
                                                        <a v-if="row['status'] != '4'" href="javascript:void(0);" class="download-link inline-block rounded border border-sky-600 bg-sky-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-sky-600 focus:outline-none focus:ring active:text-sky-500" @click="onUpload(row)">Upload</a>
                                                        <a v-if="row['payment_image'] != ''" href="javascript:void(0);" class="download-link inline-block rounded border border-teal-600 bg-teal-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-teal-600 focus:outline-none focus:ring active:text-teal-500" @click="showImages(row['payment_image'])">Lihat</a>
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
                                    <a href="#" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
                                        <span class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>

                                        <div class="sm:flex sm:justify-between sm:gap-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900 sm:text-xl">{{ form.field.detail.po_number }}</h3>

                                                <p class="mt-1 text-xs font-medium text-gray-600">{{ form.field.detail.client_name }}</p>
                                            </div>

                                            <div class="hidden sm:block sm:shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="lg:flex lg:items-start lg:gap-12">
                                                <div class="grow lg:mt-0">
                                                    <div class="space-y-4 rounded-lg">
                                                        <div class="space-y-1">
                                                            <dl class="flex items-center justify-between gap-4">
                                                                <dt class="text-pretty text-sm font-bold text-gray-900 dark:text-gray-400">{{ form.field.detail.supplier_name }}</dt>
                                                                <dd class="text-pretty text-sm font-medium text-gray-900 dark:text-white"></dd>
                                                            </dl>

                                                            <dl class="flex items-center justify-between gap-4">
                                                                <dt class="text-pretty text-sm font-normal text-gray-500 dark:text-gray-400">Subtotal</dt>
                                                                <dd class="text-pretty text-sm font-medium text-gray-900 dark:text-white">{{ form.field.detail.po_amount }}</dd>
                                                            </dl>

                                                            <dl class="flex items-center justify-between gap-4">
                                                                <dt class="text-pretty text-sm font-normal text-gray-500 dark:text-gray-400">Supplier %</dt>
                                                                <dd class="text-pretty text-sm font-medium text-gray-900">{{ form.field.detail.persentase_supplier }}</dd>
                                                            </dl>
                                                        </div>

                                                        <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                                            <dt class="text-pretty text-sm font-bold text-gray-900 dark:text-white">Total</dt>
                                                            <dd class="text-pretty text-sm font-bold text-gray-900 dark:text-white">{{ form.field.detail.po_nett }}</dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <dl class="mt-6 flex gap-4 sm:gap-6">
                                            <div class="flex flex-col-reverse">
                                                <dt class="text-sm font-medium text-gray-600">{{ form.field.detail.po_date }}</dt>
                                                <dd class="text-xs text-gray-500">Tanggal</dd>
                                            </div>

                                            <div class="flex flex-col-reverse">
                                                <dt class="text-sm font-medium text-gray-600">{{ form.field.detail.status == '3' ? 'Belum Lunas' : 'Butuh Approval' }}</dt>
                                                <dd class="text-xs text-gray-500">Status</dd>
                                            </div>
                                        </dl>
                                    </a>
                                    <div class="rounded-md border p-2 font-[sans-serif] shadow-sm">
                                        <file-pond
                                            name="images"
                                            ref="images"
                                            label-idle='<div class="flex justify-center gap-1 items-center"><div class="p-3 items-center"><svg class="size-8 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg></div><div>Upload file Bukti Transfer (.jpg,.png,jpeg)...</div></div>'
                                            :allow-multiple="false"
                                            accepted-file-types="image/jpeg, image/png, image/jpg"
                                            label-file-type-not-allowed="Hanya file (.jpg,.png,jpeg) yang diperbolehkan."
                                            file-validate-type-label-expected-types="Memerlukan file Bukti Transfer (.jpg,.png,jpeg)"
                                            max-file-size="1MB"
                                            v-on:init="handleFilePondInit"
                                            credits="false"
                                            v-on:updatefiles="onChangeImages"
                                        />
                                        <dt class="text-xs font-medium text-slate-500"><span class="text-red-500">*</span> Hanya file (<span class="text-red-500">.jpg,.png,jpeg</span>) yang diperbolehkan.</dt>
                                    </div>
                                </div>
                            </form>
                        </VeeForm>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <TransitionRoot as="template" :show="open_images">
        <Dialog class="relative z-50" @close="open_images = false">
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
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Bukti Pembayaran</DialogTitle>
                                        <div class="mt-2 flex justify-center p-1">
                                            <img :src="form.image_url" class="rounded-lg shadow-md" :style="{ height: '28.125rem', width: '18.75rem' }" alt="Preview" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open_images = false">Close</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

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
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Detail {{ header_detail.po_number }}</DialogTitle>
                                        <div class="mt-2 h-[60vh] w-[82vh] overflow-scroll p-1 sm:h-[65vh] sm:w-[190vh]">
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
                                            <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12">
                                                <div class="mt-6 grow sm:mt-8 lg:mt-0">
                                                    <div class="space-y-4 rounded-lg border border-gray-100 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-800">
                                                        <div class="grid grid-cols-1 gap-1 lg:grid-cols-3 lg:gap-8">
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
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:justify-end sm:gap-2 sm:px-6">
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
            open_images: false,
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

            isAllChecked: false,
            selectedRows: [],

            form: {
                data: true,
                upload: false,

                image_url: '',

                field: {
                    detail: [],
                    images: '',
                },

                submitted: false,
            },
        }
    },

    mounted() {
        this.getData()
    },

    methods: {
        getData() {
            this.data = []

            let loader = this.$loading.show()
            window.axios
                .get('/transactions/po-paid')
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
                .get('/transactions/po-paid/x0y0z0', {
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

        clearForm() {
            this.form.submitted = false
            this.form.field.images = ''
            this.form.field.detail = []
            this.$refs.images.removeFiles()
        },

        showImages(file) {
            this.form.image_url = file
            this.open_images = true
        },

        onUpload(row) {
            this.form.data = false
            this.form.upload = true

            this.clearForm()

            this.form.field.detail = row
        },

        cancel() {
            this.form.data = true
            this.form.upload = false

            this.clearForm()
            this.$refs.form.resetForm()
            this.getData()
        },

        handleFilePondInit: function () {},

        onChangeImages() {
            const files = this.$refs.images.getFiles()
            if (files.length > 0) {
                this.form.field.images = files[0].file
            } else {
                this.form.field.images = null
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
                        Object.keys(this.form.field.detail).forEach((value) => {
                            form_data.append(value, this.form.field.detail[value])
                        })
                        form_data.append('file_images', this.form.field.images)

                        window.axios
                            .post('/transactions/po-paid?menu=' + this.$route.name, form_data)
                            .then((response) => {
                                loader.hide()
                                this.$notyf.success(response.data)
                                this.cancel()
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
                })
            }
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
