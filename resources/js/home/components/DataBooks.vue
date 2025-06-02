<template>
    <div class="w-full px-1 py-1 sm:px-0">
        <TabGroup :selectedIndex="form.tabs" :defaultIndex="1">
            <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
                <Tab as="template" key="data">
                    <button :class="['w-full rounded-lg py-2.5 text-sm font-semibold leading-5', 'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2', form.data ? 'bg-white text-blue-700 shadow' : 'text-blue-100 hover:bg-white/[0.12] hover:text-white']">Data</button>
                </Tab>
                <Tab as="template" key="upload">
                    <button :class="['w-full rounded-lg py-2.5 text-sm font-semibold leading-5', 'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2', form.upload ? 'bg-white text-blue-700 shadow' : 'text-blue-100 hover:bg-white/[0.12] hover:text-white']">Upload</button>
                </Tab>
                <Tab as="template" key="review">
                    <button :class="['w-full rounded-lg py-2.5 text-sm font-semibold leading-5', 'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2', form.review ? 'bg-white text-blue-700 shadow' : 'text-blue-100 hover:bg-white/[0.12] hover:text-white']">Review</button>
                </Tab>
            </TabList>

            <TabPanels class="mt-2">
                <TabPanel class="rounded-xl bg-white p-3">
                    <div class="flex justify-between">
                        <div class="button-nav flex gap-2">
                            <button class="group relative inline-flex items-center overflow-hidden rounded bg-indigo-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-indigo-500" @click="onUpload">
                                <span class="absolute -start-full transition-all group-hover:start-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                                    </svg>
                                </span>

                                <span class="text-sm font-medium transition-all group-hover:ms-4"> Upload Enkripsi File </span>
                            </button>
                            <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click="onDraft">
                                <span class="absolute -start-full transition-all group-hover:start-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
                                        />
                                    </svg>
                                </span>

                                <span class="text-sm font-medium transition-all group-hover:ms-4"> Pengajuan buku </span>
                            </button>
                            <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click="exportData">
                                <span class="absolute -start-full transition-all group-hover:start-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </span>

                                <span class="text-sm font-medium transition-all group-hover:ms-4"> Export Buku </span>
                            </button>
                        </div>
                    </div>

                    <div class="border-b border-gray-200 p-2"></div>

                    <div class="mb-4 mt-4 flex items-center justify-between">
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
                        <div class="rounded-lg border border-gray-300 shadow-sm">
                            <div class="overflow-x-auto rounded-t-lg">
                                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                    <thead class="bg-white text-left">
                                        <tr>
                                            <th class="cursor-pointer border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-100">
                                                <input type="checkbox" id="selectAll" :checked="isAllSelected" @change="toggleSelectAll" class="size-5 rounded border-gray-300" />
                                            </th>
                                            <th v-for="(header, index) in headers" :key="index" class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-100">
                                                <span>{{ header.label }}</span>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200">
                                        <template v-if="paginatedData.length > 0">
                                            <tr v-for="row in paginatedData" :key="row.book_id" class="even:bg-gray-50 hover:bg-gray-100">
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <input v-if="row.status == '1'" type="checkbox" v-model="selectedRows" :value="row" class="size-5 rounded border-gray-300" />
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
                                                    <template v-else-if="header.key == 'rentprice' || header.key == 'sellprice' || header.key == 'retailprice'">
                                                        <span class="flex place-content-end">{{ row[header.key] }}</span>
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
                </TabPanel>
                <TabPanel class="rounded-xl bg-white p-3">
                    <div class="flex justify-between">
                        <div class="button-nav flex gap-2">
                            <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click="submit">
                                <span class="absolute -start-full transition-all group-hover:start-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </span>

                                <span class="text-sm font-medium transition-all group-hover:ms-4"> Submit </span>
                            </button>
                            <button class="group relative inline-flex items-center overflow-hidden rounded bg-rose-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-rose-500" @click="cancelUpload">
                                <span class="absolute -start-full transition-all group-hover:start-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </span>

                                <span class="text-sm font-medium transition-all group-hover:ms-4"> Cancel </span>
                            </button>
                        </div>
                    </div>

                    <div class="border-b border-gray-200 p-2"></div>

                    <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                        <form @submit.prevent="handleSubmit($event, submit)">
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div class="flex h-32 flex-col justify-between rounded-md border p-2 font-[sans-serif] shadow-sm">
                                    <file-pond
                                        name="file"
                                        ref="file"
                                        label-idle='<div class="flex justify-center gap-1 items-center"><div class="p-3 items-center"><svg class="size-8 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg></div><div>Upload file Enkripsi (.zip)...</div></div>'
                                        :allow-multiple="false"
                                        accepted-file-types="zip,application/zip,application/x-zip,application/x-zip-compressed"
                                        label-file-type-not-allowed="Hanya file .zip yang diperbolehkan."
                                        file-validate-type-label-expected-types="Memerlukan file (.zip)"
                                        max-file-size="300MB"
                                        v-on:init="handleFilePondInit"
                                        credits="false"
                                        v-on:updatefiles="onChangeFile"
                                        style-class="custom-filepond"
                                    />
                                    <dt class="text-xs font-medium text-slate-500"><span class="text-red-500">*</span> File <span class="text-red-500">.Zip hasil Enkripsi dengan nama file file_</span>.</dt>
                                </div>
                                <div class="flex h-32 flex-col justify-between rounded-md border p-2 font-[sans-serif] shadow-sm">
                                    <file-pond
                                        name="cover"
                                        ref="cover"
                                        label-idle='<div class="flex justify-center gap-1 items-center"><div class="p-3 items-center"><svg class="size-8 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg></div><div>Upload file Cover (.zip)...</div></div>'
                                        :allow-multiple="false"
                                        accepted-file-types="zip,application/zip,application/x-zip,application/x-zip-compressed"
                                        label-file-type-not-allowed="Hanya file .zip yang diperbolehkan."
                                        file-validate-type-label-expected-types="Memerlukan file (.zip)"
                                        max-file-size="300MB"
                                        v-on:init="handleFilePondInit"
                                        credits="false"
                                        v-on:updatefiles="onChangeCover"
                                        style-class="custom-filepond"
                                    />
                                    <dt class="text-xs font-medium text-slate-500"><span class="text-red-500">*</span> File <span class="text-red-500">.Zip hasil Enkripsi dengan nama file cover_</span>.</dt>
                                </div>
                                <div class="flex h-32 flex-col justify-between rounded-md border p-2 font-[sans-serif] shadow-sm">
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
                                    <dt class="text-xs font-medium text-slate-500"><span class="text-red-500">*</span> File <span class="text-red-500">.xlsx hasil Enkripsi</span>.</dt>
                                </div>
                            </div>
                        </form>
                    </VeeForm>
                </TabPanel>
                <TabPanel class="rounded-xl bg-white p-3">
                    <div class="flex justify-between">
                        <div class="button-nav flex gap-2">
                            <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click="submitReview">
                                <span class="absolute -start-full transition-all group-hover:start-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </span>

                                <span class="text-sm font-medium transition-all group-hover:ms-4"> Ajukan Buku </span>
                            </button>
                            <button class="group relative inline-flex items-center overflow-hidden rounded bg-rose-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-rose-500" @click="cancelReview">
                                <span class="absolute -start-full transition-all group-hover:start-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </span>

                                <span class="text-sm font-medium transition-all group-hover:ms-4"> Cancel </span>
                            </button>
                        </div>
                    </div>

                    <div class="border-b border-gray-200 p-2"></div>

                    <div class="mt-4">
                        <div class="overflow-auto rounded-lg border border-gray-200">
                            <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                                <form @submit.prevent="handleSubmit($event, submit)">
                                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                        <thead class="ltr:text-left rtl:text-right">
                                            <tr>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">COVER</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">JUDUL</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">FILE</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">UKURAN</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">STATUS</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">PENULIS</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">
                                                    <select name="publisher_all" id="publisher_all" class="rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" @change="changePublisher">
                                                        <option value="">Pilih Penerbit</option>
                                                        <option v-for="(value, key) in options.publisher" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </select>
                                                </th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">ISBN</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">EISBN</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">
                                                    <select name="category_all" id="category_all" class="rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" @change="changeCategory">
                                                        <option value="">Pilih Kategori Buku</option>
                                                        <option v-for="(value, key) in options.category" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </select>
                                                </th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">KOTA</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">TAHUN</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">EDISI</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">HALAMAN</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">SINOPSIS</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">UKURAN</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">JILID</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">UMUR</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">HARGA JUAL</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">HARGA PINJAM</th>
                                                <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">HARGA RETAIL</th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-gray-200">
                                            <tr v-for="(row, key) in form.field.success[0]" :key="key" class="odd:bg-gray-50">
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <img :src="row.coverFile" class="thumbnail rounded-sm" alt="covers" @click="showImages(row.coverFile)" />
                                                </td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.title }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.fileName }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.size }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                        </svg>
                                                        <p class="whitespace-nowrap text-sm">Draft</p>
                                                    </span>
                                                </td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.writer }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <Field as="select" :rules="validatePublisher" :name="'publisher' + key" :id="'publisher' + key" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" v-model="row.publisher">
                                                        <option value="">Pilih Penerbit</option>
                                                        <option v-for="(value, key) in options.publisher" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </Field>
                                                    <ErrorMessage :name="'publisher' + key" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                                </td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.isbn }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.eisbn }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <Field as="select" :rules="validateCategory" :name="'category' + key" :id="'category' + key" class="relative w-full rounded-md border-gray-300 text-gray-700 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 sm:text-sm" v-model="row.category">
                                                        <option value="">Pilih Kategori Buku</option>
                                                        <option v-for="(value, key) in options.category" :key="key" :value="value.id">{{ value.name }}</option>
                                                    </Field>
                                                    <ErrorMessage :name="'category' + key" class="mt-1 block text-xs text-red-600 dark:text-red-500" />
                                                </td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.city }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.years }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.edition }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.page }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <a href="javascript:void(0)" class="whitespace-nowrap" @click="showSinopsis(row.sinopsis)">{{ row.sinopsis.substring(0, 10) + '...' }}</a>
                                                </td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.size }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.volume }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">{{ row.ages }}</td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <span class="flex place-content-end">{{ row.sellPrice }}</span>
                                                </td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <span class="flex place-content-end">{{ row.rentPrice }}</span>
                                                </td>
                                                <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                    <span class="flex place-content-end">{{ row.retailPrice }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </VeeForm>
                        </div>
                    </div>
                </TabPanel>
            </TabPanels>
        </TabGroup>
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

    <TransitionRoot as="template" :show="open_notif">
        <Dialog class="relative z-50" static>
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
                <div class="flex min-h-full items-start justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-1 sm:w-full">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 h-full max-h-[40rem] w-full overflow-auto text-center sm:mt-0 sm:max-h-[30rem] sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold text-gray-900">Notifikasi</DialogTitle>
                                        <div class="mt-2">
                                            <div class="overflow-auto rounded-lg border border-gray-200">
                                                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                                    <thead class="ltr:text-left rtl:text-right">
                                                        <tr>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">FILENAME</th>
                                                            <th class="whitespace-nowrap px-4 py-2 font-semibold text-gray-900">KETERANGAN</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="divide-y divide-gray-200">
                                                        <tr v-for="(row, key) in form.field.failed[0]" :key="key" class="odd:bg-gray-50">
                                                            <td class="px-4 py-2 text-gray-700">{{ row.fileName }}</td>
                                                            <td class="flex flex-wrap justify-start gap-2 px-4 py-2 text-gray-700">
                                                                <span v-if="row.isbn !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> ISBN {{ row.isbn }}</span>
                                                                <span v-if="row.eisbn !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> EISBN {{ row.eisbn }}</span>
                                                                <span v-if="row.title !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Judul {{ row.title }}</span>
                                                                <span v-if="row.writer !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Penulis {{ row.writer }}</span>
                                                                <span v-if="row.size !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Ukuran Buku {{ row.size }}</span>
                                                                <span v-if="row.years !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Tahun {{ row.years }}</span>
                                                                <span v-if="row.volume !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Jilid {{ row.volume }}</span>
                                                                <span v-if="row.edition !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Edisi {{ row.edition }}</span>
                                                                <span v-if="row.page !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Halaman {{ row.page }}</span>
                                                                <span v-if="row.sinopsis !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Sinopsis {{ row.sinopsis }}</span>
                                                                <span v-if="row.sellPrice !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Harga Jual {{ row.sellPrice }}</span>
                                                                <span v-if="row.rentPrice !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Harga Pinjam {{ row.rentPrice }}</span>
                                                                <span v-if="row.retailPrice !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Harga Retail {{ row.retailPrice }}</span>
                                                                <span v-if="row.city !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Kota {{ row.city }}</span>
                                                                <span v-if="row.ages !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> Umur {{ row.ages }}</span>
                                                                <span v-if="row.fileExist !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> File Enkripsi {{ row.fileExist }}</span>
                                                                <span v-if="row.coverExist !== ''" class="whitespace-nowrap rounded-md bg-rose-100 px-2.5 py-0.5 text-sm font-semibold text-rose-700"> File Cover {{ row.coverExist }}</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-400 sm:ml-3 sm:w-auto" @click="(open_notif = false), onReview()">Next</button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="(open_notif = false), cancelUpload()" ref="cancelButtonRef">Cancel</button>
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
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot, TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
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
        TabGroup,
        TabList,
        Tab,
        TabPanels,
        TabPanel,
        ExclamationTriangleIcon,
        InformationCircleIcon,
    },

    data() {
        return {
            open: false,
            open_sinopsis: false,
            open_error: false,
            open_notif: false,
            image_url: '',
            detail_sinopsis: '',
            selectedRows: [],
            selected: [],

            headers: [
                { label: 'COVER', key: 'path_cover' },
                { label: 'JUDUL', key: 'title' },
                { label: 'FILE', key: 'filename' },
                { label: 'UKURAN', key: 'file_size' },
                { label: 'STATUS', key: 'status' },
                { label: 'PENULIS', key: 'writer' },
                { label: 'PUBLISHER', key: 'publisher_desc' },
                { label: 'ISBN', key: 'isbn' },
                { label: 'EISBN', key: 'eisbn' },
                { label: 'KATEGORI', key: 'category_desc' },
                { label: 'KOTA', key: 'city' },
                { label: 'TAHUN', key: 'year' },
                { label: 'EDISI', key: 'edition' },
                { label: 'HALAMAN', key: 'page' },
                { label: 'SINOPSIS', key: 'sinopsis' },
                { label: 'UKURAN', key: 'size' },
                { label: 'JILID', key: 'volume' },
                { label: 'UMUR', key: 'age' },
                { label: 'HARGA JUAL', key: 'sellprice' },
                { label: 'HARGA PINJAM', key: 'rentprice' },
                { label: 'HARGA RETAIL', key: 'retailprice' },
                { label: 'TANGGAL UPLOAD', key: 'createdate' },
            ],
            data: [],
            searchQuery: '',
            rowsPerPage: 10,
            currentPage: 1,
            sortKey: '',
            sortAsc: true,
            perPageOptions: [10, 20, 30, 40, 50],

            options: {
                category: [],
                publisher: [],
                format: [],
            },

            form: {
                submitted: false,
                submit_count: 0,

                data: true,
                upload: false,
                review: false,
                tabs: 0,

                field: {
                    file: '',
                    cover: '',
                    excel: '',
                    success: [],
                    exists: [],
                    failed: [],
                },
            },
        }
    },

    mounted() {
        this.getData()
    },

    methods: {
        clearForm() {
            this.form.submitted = false

            this.form.field.file = ''
            this.form.field.cover = ''
            this.form.field.excel = ''

            this.$refs.file.removeFiles()
            this.$refs.cover.removeFiles()
            this.$refs.excel.removeFiles()
        },

        getData() {
            this.data = []

            let loader = this.$loading.show()
            window.axios
                .get('/upload/data-books', {
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

        getCategory() {
            this.options.category = []

            window.axios
                .get('/upload/data-books/x0y0z0', {
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

        changeCategory(event) {
            const selectedValue = event.target.value
            this.form.field.success[0].forEach((element) => {
                element.category = selectedValue
            })
        },

        validateCategory(value) {
            if (!value) {
                return 'Kategory tidak boleh kosong!'
            }

            return true
        },

        getPublisher() {
            this.options.publisher = []

            window.axios
                .get('/upload/data-books/x0y0z0', {
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

        changePublisher(event) {
            const selectedValue = event.target.value
            this.form.field.success[0].forEach((element) => {
                element.publisher = selectedValue
            })
        },

        validatePublisher(value) {
            if (!value) {
                return 'Publisher tidak boleh kosong!'
            }

            return true
        },

        showImages(file) {
            this.image_url = file
            this.open = true
        },

        showSinopsis(text) {
            this.detail_sinopsis = text
            this.open_sinopsis = true
        },

        onUpload() {
            this.form.data = false
            this.form.upload = true
            this.form.review = false
            this.form.tabs = 1

            this.form.field.file = ''
            this.form.field.cover = ''
            this.form.field.excel = ''
        },

        onReview() {
            this.form.data = false
            this.form.upload = false
            this.form.review = true
            this.form.tabs = 2

            this.getCategory()
            this.getPublisher()
        },

        onDraft() {
            this.form.data = false
            this.form.upload = false
            this.form.review = true
            this.form.tabs = 2

            this.form.field.success = []

            let data = this.selectedRows.map((element) => ({
                bookId: element.book_id,
                fileName: element.filename,
                isbn: element.isbn,
                eisbn: element.eisbn,
                title: element.title,
                writer: element.writer,
                size: element.size,
                years: element.year,
                volume: element.volume,
                edition: element.edition,
                page: element.page,
                sinopsis: element.sinopsis,
                sellPrice: element.sellprice,
                rentPrice: element.rentprice,
                retailPrice: element.retailprice,
                city: element.city,
                ages: element.age,
                fileExist: element.fileExist,
                coverExist: element.coverExist,
                coverFile: element.path_cover,
                publisher: element.publisher_id,
                category: element.category_id,
            }))

            this.form.field.success = [data]

            this.getCategory()
            this.getPublisher()
        },

        cancelUpload() {
            this.form.data = true
            this.form.upload = false
            this.form.review = false

            this.clearForm()
            this.getData()

            this.form.tabs = 0
        },

        cancelReview() {
            this.form.data = true
            this.form.upload = false
            this.form.review = false

            this.form.field.success = []
            this.form.field.exists = []
            this.form.field.failed = []

            this.getData()

            this.form.tabs = 0
        },

        handleFilePondInit: function () {
            this.$refs.file.removeFiles()
            this.$refs.cover.removeFiles()
            this.$refs.excel.removeFiles()
        },

        onChangeFile() {
            const files = this.$refs.file.getFiles()
            if (files.length > 0) {
                this.form.field.file = files[0].file
            } else {
                this.form.field.file = ''
            }
        },

        onChangeCover() {
            const files = this.$refs.cover.getFiles()
            if (files.length > 0) {
                this.form.field.cover = files[0].file
            } else {
                this.form.field.cover = ''
            }
        },

        onChangeExcel() {
            const files = this.$refs.excel.getFiles()
            if (files.length > 0) {
                this.form.field.excel = files[0].file
            } else {
                this.form.field.excel = ''
            }
        },

        toggleSelectAll() {
            if (this.isAllSelected) {
                this.selectedRows = []
            } else {
                this.selectedRows = this.paginatedData.map((row) => row)
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

        submit() {
            this.form.submit_count += 1
            if (this.form.submit_count === 1) {
                let loader = this.$loading.show()

                let form_data = new FormData()
                Object.keys(this.form.field).forEach((value) => {
                    form_data.append(value, this.form.field[value])
                })

                window.axios
                    .post('/upload/data-books?menu=' + this.$route.name, form_data, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    })
                    .then((response) => {
                        this.form.submit_count = 0

                        this.clearForm()

                        loader.hide()
                        if (response.data.data.failed.length > 0) {
                            this.form.field.failed = response.data.data.failed
                            this.form.field.exists = response.data.data.exists
                            this.form.field.success = response.data.data.new
                            this.open_notif = true
                            this.$notyf.error(response.data.message)
                        } else {
                            this.form.field.success = response.data.data.new
                            this.$notyf.success(response.data.message)
                        }
                    })
                    .catch((e) => {
                        this.form.submit_count = 0

                        this.clearForm()

                        loader.hide()
                        Object.keys(e.response.data.errors).forEach((key) => {
                            this.$notyf.error(`${e.response.data.errors[key]}`)
                        })
                    })
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
                                .post('/upload/data-books-submit/submit-draft?menu=' + this.$route.name, this.form.field.success)
                                .then((response) => {
                                    this.cancelReview()
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

        async exportData() {
            await window
                .axios({
                    url: '/upload/encrypt-books-excel/export-data',
                    method: 'POST',
                    responseType: 'blob',
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'data_buku.xlsx')
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
                    url: '/upload/data-books-download/download-file',
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
            return this.paginatedData.length > 0 && this.paginatedData.every((row) => this.selectedRows.includes(row))
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
