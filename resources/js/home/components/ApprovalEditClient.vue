<template>
    <div class="w-100 h-100 mx-auto flex flex-col overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between">
                <div class="button-nav flex gap-2">
                    <template v-if="form.edit">
                        <button v-if="form.after.flag_appr == 'N'" class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-emerald-500" @click.prevent="submit">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Approve Client </span>
                        </button>
                        <button v-if="form.after.flag_appr == 'N'" class="group relative inline-flex items-center overflow-hidden rounded bg-rose-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-rose-500" @click.prevent="reject">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Reject Client </span>
                        </button>
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-sky-500 px-8 py-3 text-white focus:outline-none focus:ring active:bg-sky-500" @click="cancel">
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
                    <button class="tab-btn shrink-0 rounded-lg p-2 px-4 py-2 text-sm font-medium" :class="form.edit ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-sky-50 hover:text-gray-700'">Form</button>
                </div>

                <div class="tab-content mt-4 min-h-[23.75rem] flex-grow overflow-auto">
                    <div class="tab-panel" :class="form.data ? '' : 'hidden'">
                        <div class="min-h-[23.75rem] flex-grow overflow-auto">
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
                                            <thead class="bg-white text-left">
                                                <tr>
                                                    <!-- <th class="cursor-pointer border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-50">
                                                        <input type="checkbox" id="selectAll" :checked="isAllSelected" @change="toggleSelectAll" class="size-5 rounded border-gray-300" />
                                                    </th> -->
                                                    <th v-for="(header, index) in headers" :key="index" class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-100">
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
                                                    <th class="cursor-pointer whitespace-nowrap border-b border-gray-200 px-4 py-2 text-left hover:bg-gray-100">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-y divide-gray-200">
                                                <template v-if="paginatedData.length > 0">
                                                    <tr v-for="row in paginatedData" :key="row.client_id" class="even:bg-gray-50 hover:bg-gray-100">
                                                        <!-- <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                            <input v-if="row.flag_appr == 'N'" type="checkbox" v-model="selectedRows" :value="row.client_id" class="size-5 rounded border-gray-300" />
                                                        </td> -->
                                                        <td v-for="header in headers" :key="header.key" class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                            <template v-if="header.key == 'flag_appr'">
                                                                <span v-if="row[header.key] == 'N'" class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                    </svg>
                                                                    <p class="whitespace-nowrap text-sm">Need Approval</p>
                                                                </span>
                                                                <span v-if="row[header.key] == 'Y'" class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                    <p class="whitespace-nowrap text-sm">Approved</p>
                                                                </span>
                                                                <span v-if="row[header.key] == 'R'" class="inline-flex items-center justify-center rounded-full bg-rose-100 px-2.5 py-0.5 text-rose-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                    <p class="whitespace-nowrap text-sm">Reject</p>
                                                                </span>
                                                            </template>
                                                            <template v-else-if="header.key == 'logo'">
                                                                <img v-if="row[header.key]" :src="row[header.key]" class="thumbnail h-5 w-10 rounded-sm" alt="covers" @click="showImages(row[header.key])" />
                                                            </template>
                                                            <template v-else-if="header.key == 'logo_small'">
                                                                <img v-if="row[header.key]" :src="row[header.key]" class="thumbnail h-5 w-10 rounded-sm" alt="covers" @click="showImages(row[header.key])" />
                                                            </template>
                                                            <template v-else>
                                                                {{ row[header.key] }}
                                                            </template>
                                                        </td>
                                                        <td class="whitespace-nowrap border-b border-gray-200 px-4 py-2">
                                                            <a v-if="row['flag_appr'] == 'N'" href="javascript:void(0);" class="download-link inline-block rounded border border-blue-600 bg-blue-600 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500" @click="getDetail(row)">Detail</a>
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
                    <div class="tab-panel" :class="form.edit ? '' : 'hidden'">
                        <div class="mt-2 grid grid-cols-6 gap-4">
                            <div class="col-span-6 sm:col-span-3">
                                <article class="rounded-xl border-2 border-gray-100 bg-white">
                                    <div class="flex justify-start">
                                        <strong class="-mb-[2px] -me-[2px] inline-flex items-center gap-1 rounded-ee-xl rounded-ss-xl bg-rose-500 px-3 py-1.5 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                                                />
                                            </svg>

                                            <span class="text-[10px] font-medium sm:text-xs">Before!</span>
                                        </strong>
                                    </div>

                                    <div class="flex items-start gap-4 p-4 sm:p-6 lg:p-8">
                                        <div class="flow-root">
                                            <dl class="-my-3 divide-y divide-gray-100 text-sm">
                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Client ID</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.client_id }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Instansi</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.instansi_name }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Aplikasi</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.application_name }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Alamat Website</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.web_add }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Alamat</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.address }} {{ form.before.kelurahan_name }} {{ form.before.kecamatan_name }} {{ form.before.kabupaten_name }} {{ form.before.provinsi_name }} {{ form.before.negara_name }} {{ form.before.kodepos }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">No. NPWP</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.npwp }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Penanggung Jawab</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.pers_responsible }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Jabatan Penanggung Jawab</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.pos_pers_responsible }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Penandatanganan MOU</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.mou_sign_name }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Jabatan Penandatanganan MOU</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.pos_sign_name }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Pengelola (Admin)</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.administrator_name }}</dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nomor HP/WA (Admin)</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">{{ form.before.administrator_phone }}</dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <article class="rounded-xl border-2 border-gray-100 bg-white">
                                    <div class="flex justify-start">
                                        <strong class="-mb-[2px] -me-[2px] inline-flex items-center gap-1 rounded-ee-xl rounded-ss-xl bg-emerald-500 px-3 py-1.5 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                                                />
                                            </svg>

                                            <span class="text-[10px] font-medium sm:text-xs">After!</span>
                                        </strong>
                                    </div>

                                    <div class="flex items-start gap-4 p-4 sm:p-6 lg:p-8">
                                        <div class="flow-root">
                                            <dl class="-my-3 divide-y divide-gray-100 text-sm">
                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Client ID</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.client_id != form.before.client_id ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.client_id }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Instansi</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.instansi_name != form.before.instansi_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.instansi_name }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Aplikasi</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.application_name != form.before.application_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.application_name }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Alamat Website</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.web_add != form.before.web_add ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.web_add }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Alamat</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.address != form.before.address ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">{{ form.after.address }}</span> <span :class="form.after.kelurahan_name != form.before.kelurahan_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">{{ form.after.kelurahan_name }}</span> <span :class="form.after.kecamatan_name != form.before.kecamatan_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">{{ form.after.kecamatan_name }}</span> <span :class="form.after.kabupaten_name != form.before.kabupaten_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">{{ form.after.kabupaten_name }}</span> <span :class="form.after.provinsi_name != form.before.provinsi_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">{{ form.after.provinsi_name }}</span> <span :class="form.after.negara_name != form.before.negara_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">{{ form.after.negara_name }}</span> <span :class="form.after.kodepos != form.before.kodepos ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">{{ form.after.kodepos }}</span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">No. NPWP</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.npwp != form.before.npwp ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.npwp }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Penanggung Jawab</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.pers_responsible != form.before.pers_responsible ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.pers_responsible }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Jabatan Penanggung Jawab</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.pos_pers_responsible != form.before.pos_pers_responsible ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.pos_pers_responsible }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Penandatanganan MOU</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.mou_sign_name != form.before.mou_sign_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.mou_sign_name }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Jabatan Penandatanganan MOU</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.pos_sign_name != form.before.pos_sign_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.pos_sign_name }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nama Pengelola (Admin)</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.administrator_name != form.before.administrator_name ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.administrator_name }}
                                                        </span>
                                                    </dd>
                                                </div>

                                                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                    <dt class="font-medium text-gray-900">Nomor HP/WA (Admin)</dt>
                                                    <dd class="text-gray-700 sm:col-span-2">
                                                        <span :class="form.after.administrator_phone != form.before.administrator_phone ? 'inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700' : ''">
                                                            {{ form.after.administrator_phone }}
                                                        </span>
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </article>
                            </div>
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
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Images</DialogTitle>
                                        <div class="mt-2 flex justify-center p-1">
                                            <img :src="image_url" class="rounded-lg shadow-md" :style="{ height: '450px', width: '700px' }" alt="Preview" />
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
            image_url: '',
            userRole: '',

            headers: [
                { label: 'Client ID', key: 'client_id' },
                { label: 'Nama Instansi', key: 'instansi_name' },
                { label: 'Nama Aplikasi', key: 'application_name' },
                { label: 'Status', key: 'flag_appr' },
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
                data: true,
                edit: false,
                submitted: false,

                before: [],
                after: [],
            },
        }
    },
    mounted() {
        this.getData()
    },

    methods: {
        toggleSelectAll() {
            if (this.isAllSelected) {
                this.selectedRows = []
            } else {
                this.selectedRows = this.paginatedData.filter((row) => row.flag_appr === 'N').map((row) => row.client_id)
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

        clearForm() {
            this.form.submitted = false
            this.form.before = []
            this.form.after = []
        },

        getDetail(row) {
            this.form.data = false
            this.form.edit = true

            this.form.after = []
            this.form.before = []

            let loader = this.$loading.show()

            window.axios
                .get('/transactions/approval-edit-client/x0y0z0', {
                    params: {
                        param: 'client-mst',
                        client: row.client_id,
                    },
                })
                .then((response) => {
                    this.form.before = response.data[0]
                    this.form.after = row

                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },

        getData() {
            let loader = this.$loading.show()

            window.axios
                .get('/transactions/approval-edit-client', {
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

        showImages(file) {
            this.image_url = file
            this.open = true
        },

        pushSelected(row) {
            this.selectedRows.push(row)
        },

        submit() {
            if (!this.form.submitted) {
                this.form.submitted = true

                let loader = this.$loading.show()
                window.axios
                    .post('/transactions/approval-edit-client?menu=' + this.$route.name, this.form.after)
                    .then((response) => {
                        this.form.submitted = false
                        this.cancel()
                        loader.hide()
                        this.$notyf.success('Successfully Approve Edit Client')
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
        },

        reject() {
            if (!this.form.submitted) {
                this.form.submitted = true

                let loader = this.$loading.show()
                window.axios
                    .post('/transactions/approval-edit-client/reject?menu=' + this.$route.name, this.form.after)
                    .then((response) => {
                        this.form.submitted = false
                        this.cancel()
                        loader.hide()
                        this.$notyf.success('Successfully Reject Edit Client')
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
        },

        cancel() {
            this.form.data = true
            this.form.edit = false

            this.clearForm()
            this.getData()
        },
    },

    computed: {
        isAllSelected() {
            return this.paginatedData.length > 0 && this.paginatedData.every((row) => this.selectedRows.includes(row.client_id))
        },

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
