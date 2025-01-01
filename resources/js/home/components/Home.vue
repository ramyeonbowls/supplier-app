<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="flex flex-col gap-4 p-6">
            <div role="status" :class="loading ? '' : 'hidden'" class="max-w animate-pulse rounded border border-gray-200 p-4 shadow dark:border-gray-700 md:p-6">
                <div class="mb-4 h-2.5 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                <div class="h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                <span class="sr-only">Loading...</span>
            </div>

            <div :class="user.role === 0 ? '' : 'hidden'" class="mt-2 grid grid-cols-12 gap-4">
                <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                    <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                        <span class="rounded-full bg-sky-100 p-3 text-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </span>

                        <div>
                            <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.books }}</p>

                            <p class="text-sm text-gray-500">Total Buku</p>
                        </div>
                    </article>
                </div>
                <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                    <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                        <span class="rounded-full bg-emerald-100 p-3 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                                />
                            </svg>
                        </span>

                        <div>
                            <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.client }}</p>

                            <p class="text-sm text-gray-500">Total Client</p>
                        </div>
                    </article>
                </div>
                <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                    <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                        <span class="rounded-full bg-orange-100 p-3 text-orange-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 sm:size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </span>

                        <div>
                            <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.supplier }}</p>

                            <p class="text-sm text-gray-500">Total Supplier</p>
                        </div>
                    </article>
                </div>
                <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                    <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                        <span class="rounded-full bg-amber-100 p-3 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 sm:size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                        </span>

                        <div>
                            <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.distributor }}</p>

                            <p class="text-sm text-gray-500">Total Distributor</p>
                        </div>
                    </article>
                </div>
            </div>
            <div :class="user.role === 0 ? '' : 'hidden'" class="mt-1 grid grid-cols-6 gap-4">
                <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                    <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                        <span class="rounded-full bg-emerald-100 p-3 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"
                                />
                            </svg>
                        </span>

                        <div>
                            <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.publish }}</p>

                            <p class="text-sm text-gray-500">Total Buku Publish</p>
                        </div>
                    </article>
                </div>
                <div class="col-span-6 rounded-lg shadow-sm sm:col-span-3">
                    <article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-2 sm:p-6">
                        <span class="rounded-full bg-amber-100 p-3 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
                                />
                            </svg>
                        </span>

                        <div>
                            <p class="text-1xl font-medium text-gray-900 sm:text-2xl">{{ dashboard.review }}</p>

                            <p class="text-sm text-gray-500">Total Buku Review</p>
                        </div>
                    </article>
                </div>
            </div>

            <div :class="user.role === 0 ? '' : 'hidden'" class="w-full max-w-full rounded-lg bg-white p-4 shadow dark:bg-gray-800 md:p-6">
                <div class="mb-4 flex justify-between border-b border-gray-200 pb-4 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="me-3 flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                            <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="pb-1 text-2xl font-bold leading-none text-gray-900 dark:text-white">{{ dashboard.chartBooks.totals }}</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Total Upload Buku Supplier</p>
                        </div>
                    </div>
                    <div>
                        <select name="yearPeriodBook" id="yearPeriodBook" v-model="selectedYearBooks" @change="getDashboard1" class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                            <option v-for="year in filters.years" :key="year" :value="year">{{ year }}</option>
                        </select>
                    </div>
                </div>

                <div id="books-chart"></div>
                <div class="grid grid-cols-1 items-center justify-between border-t border-gray-200 dark:border-gray-700"></div>
            </div>

            <div :class="user.role === 0 ? '' : 'hidden'" class="w-full max-w-full rounded-lg bg-white p-4 shadow dark:bg-gray-800 md:p-6">
                <div class="mb-4 flex justify-between border-b border-gray-200 pb-4 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="me-3 flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                            <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9 15a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm3.845-1.855a2.4 2.4 0 0 1 1.2-1.226 1 1 0 0 1 1.992-.026c.426.15.809.408 1.111.749a1 1 0 1 1-1.496 1.327.682.682 0 0 0-.36-.213.997.997 0 0 1-.113-.032.4.4 0 0 0-.394.074.93.93 0 0 0 .455.254 2.914 2.914 0 0 1 1.504.9c.373.433.669 1.092.464 1.823a.996.996 0 0 1-.046.129c-.226.519-.627.94-1.132 1.192a1 1 0 0 1-1.956.093 2.68 2.68 0 0 1-1.227-.798 1 1 0 1 1 1.506-1.315.682.682 0 0 0 .363.216c.038.009.075.02.111.032a.4.4 0 0 0 .395-.074.93.93 0 0 0-.455-.254 2.91 2.91 0 0 1-1.503-.9c-.375-.433-.666-1.089-.466-1.817a.994.994 0 0 1 .047-.134Zm1.884.573.003.008c-.003-.005-.003-.008-.003-.008Zm.55 2.613s-.002-.002-.003-.007a.032.032 0 0 1 .003.007ZM4 14a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm3-2a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1Zm6.5-8a1 1 0 0 1 1-1H18a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-.796l-2.341 2.049a1 1 0 0 1-1.24.06l-2.894-2.066L6.614 9.29a1 1 0 1 1-1.228-1.578l4.5-3.5a1 1 0 0 1 1.195-.025l2.856 2.04L15.34 5h-.84a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="pb-1 text-2xl font-bold leading-none text-gray-900 dark:text-white">Rp. {{ dashboard.chartPo.totals }}</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Total Purchase Order</p>
                        </div>
                    </div>
                    <div>
                        <select name="yearPeriodPo" id="yearPeriodPo" v-model="selectedYearPo" @change="getDashboard2" class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                            <option v-for="year in filters.years" :key="year" :value="year">{{ year }}</option>
                        </select>
                    </div>
                </div>

                <div id="po-chart"></div>
                <div class="grid grid-cols-1 items-center justify-between border-t border-gray-200 dark:border-gray-700"></div>
            </div>

            <a href="#" :class="user.role === 1 ? '' : 'hidden'" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
                <div class="sm:flex sm:justify-between sm:gap-4">
                    <div class="flex justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 sm:text-xl">Manual Guide Daftar & Upload Buku Supplier</h3>
                        </div>

                        <div>
                            <div class="block sm:hidden md:hidden lg:hidden">
                                <button class="inline-block rounded border border-sky-500 bg-sky-500 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-sky-500 focus:outline-none focus:ring active:text-sky-500" @click="downloadFile">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="hidden sm:block">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-sky-500 px-8 py-2 text-white focus:outline-none focus:ring active:bg-sky-500" @click="downloadFile">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </span>

                            <span class="text-sm font-semibold transition-all group-hover:ms-4"> Download Guide </span>
                        </button>
                    </div>
                </div>
            </a>

            <a href="#" :class="user.role === 1 ? '' : 'hidden'" class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8">
                <span class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>

                <div class="sm:flex sm:justify-between sm:gap-4">
                    <div class="flex justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 sm:text-xl">Dokumen & Surat Perjanjian</h3>

                            <p class="mt-1 text-xs font-medium text-gray-600">{{ form.field.type }}</p>
                        </div>

                        <div>
                            <div class="block sm:hidden md:hidden lg:hidden">
                                <button class="inline-block rounded border border-emerald-500 bg-emerald-500 px-3 py-1 text-sm font-medium text-white hover:bg-transparent hover:text-emerald-500 focus:outline-none focus:ring active:text-emerald-500" @click="printDoc">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="hidden sm:block">
                        <button class="group relative inline-flex items-center overflow-hidden rounded bg-emerald-500 px-8 py-2 text-white focus:outline-none focus:ring active:bg-emerald-500" @click="printDoc">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
                                    />
                                </svg>
                            </span>

                            <span class="text-sm font-semibold transition-all group-hover:ms-4"> Print Dokumen </span>
                        </button>
                    </div>
                </div>

                <div class="mt-2">
                    <p class="text-pretty text-sm text-gray-500">{{ form.field.name }}</p>
                </div>

                <dl class="mt-2 flex gap-4 sm:gap-6">
                    <div class="flex flex-col-reverse">
                        <dd class="text-xs text-gray-500">{{ form.field.created_at }}</dd>
                        <dt class="text-sm font-medium text-gray-600">Terdaftar pada</dt>
                    </div>
                </dl>
            </a>
        </div>
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'

export default {
    data() {
        return {
            loading: true,
            user: {},

            selectedYearBooks: new Date().getFullYear(),
            selectedYearPo: new Date().getFullYear(),
            filters: {
                years: [],
            },

            form: {
                field: {
                    id: '',
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
                    npwp: '',
                    account_bank: '',
                    bank: '',
                    account_name: '',
                    bank_city: '',
                    type: '',
                    created_at: '',
                },
            },

            chartBooks: null,
            chartPo: null,
            dashboard: {
                books: 0,
                client: 0,
                supplier: 0,
                distributor: 0,
                publish: 0,
                review: 0,
                
                chartBooks: {
                    totals: 0,
                    total: [],
                    publish: [],
                    review: [],
                },

                chartPo: {
                    totals: 0,
                    gross: [],
                    nett: [],
                },
            },
        }
    },

    mounted() {
        this.getData()
        this.userinfo()
    },

    methods: {
        userinfo() {
            this.user = {}

            window.axios
                .get('/userinfo')
                .then((response) => {
                    this.user = response.data

                    if (this.user.role === 0 ) {
                        this.generateYears()
                        this.getDashboard()
                        this.getDashboard1()
                        this.getDashboard2()
                    }

                    this.loading = false
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getData() {
            let loader = this.$loading.show()
            window.axios
                .get('/profile/profile-company')
                .then((response) => {
                    let profile = response.data.data

                    this.form.field.id = profile[0].id
                    this.form.field.name = profile[0].name
                    this.form.field.email = profile[0].email
                    this.form.field.country = profile[0].country
                    this.form.field.province = profile[0].province
                    this.form.field.regency = profile[0].regency
                    this.form.field.district = profile[0].district
                    this.form.field.subdistrict = profile[0].subdistrict
                    this.form.field.postal_code = profile[0].postal_code
                    this.form.field.address = profile[0].address
                    this.form.field.handphone = profile[0].handphone
                    this.form.field.director = profile[0].director
                    this.form.field.position = profile[0].position
                    this.form.field.handphone_director = profile[0].handphone_director
                    this.form.field.person_in_charge = profile[0].pic
                    this.form.field.handphone_person_in_charge = profile[0].handphone_pic
                    this.form.field.created_at = this.formatTanggal(profile[0].created_at)
                    this.form.field.type = profile[0].type == '1' ? 'Supplier' : profile[0].type == '2' ? 'Distributor' : 'Distributor & Supplier'

                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },

        getDashboard() {
            let loader = this.$loading.show()
            window.axios
                .get('/profile/profile-company/x0y0z0', {
                    params: {
                        param: 'dashboard-admin',
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.dashboard.books = response.data.books
                    this.dashboard.client = response.data.client
                    this.dashboard.supplier = response.data.supplier
                    this.dashboard.distributor = response.data.distributor
                    this.dashboard.publish = response.data.publish
                    this.dashboard.review = response.data.review
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        getDashboard1() {
            let loader = this.$loading.show()
            window.axios
                .get('/profile/profile-company/x0y0z0', {
                    params: {
                        param: 'dashboard-admin-1',
                        periode: this.selectedYearBooks,
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.dashboard.chartBooks.totals = response.data.totals
                    this.dashboard.chartBooks.total = response.data.total
                    this.dashboard.chartBooks.publish = response.data.publish
                    this.dashboard.chartBooks.review = response.data.review

                    this.chartUploadBook()
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        chartUploadBook() {
            if (this.chartBooks) {
                this.chartBooks.destroy();
            }

            let options = {
                colors: ['#1A56DB', '#31C48D', '#FDBA8C'],
                series: [
                    {
                        name: 'Total',
                        color: '#1A56DB',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.total['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.total['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.total['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.total['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.total['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.total['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.total['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.total['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.total['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.total['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.total['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.total['Desember'] },
                        ],
                    },
                    {
                        name: 'Publish',
                        color: '#31C48D',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.publish['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.publish['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.publish['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.publish['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.publish['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.publish['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.publish['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.publish['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.publish['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.publish['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.publish['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.publish['Desember'] },
                        ],
                    },
                    {
                        name: 'Review',
                        color: '#FDBA8C',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartBooks.review['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartBooks.review['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartBooks.review['Maret'] },
                            { x: 'April', y: this.dashboard.chartBooks.review['April'] },
                            { x: 'Mei', y: this.dashboard.chartBooks.review['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartBooks.review['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartBooks.review['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartBooks.review['Agustus'] },
                            { x: 'September', y: this.dashboard.chartBooks.review['September'] },
                            { x: 'Oktober', y: this.dashboard.chartBooks.review['Oktober'] },
                            { x: 'November', y: this.dashboard.chartBooks.review['November'] },
                            { x: 'Desember', y: this.dashboard.chartBooks.review['Desember'] },
                        ],
                    },
                ],
                chart: {
                    type: 'bar',
                    height: '320px',
                    fontFamily: 'Inter, sans-serif',
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '100%',
                        borderRadiusApplication: 'end',
                        borderRadius: 8,
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    style: {
                        fontFamily: 'Inter, sans-serif',
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 1,
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 0,
                    colors: ['transparent'],
                },
                grid: {
                    show: false,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -14,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: false,
                },
                xaxis: {
                    floating: false,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: 'Inter, sans-serif',
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                        },
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: false,
                },
                fill: {
                    opacity: 1,
                },
            }

            if (document.getElementById('books-chart') && typeof ApexCharts !== 'undefined') {
                this.chartBooks = new ApexCharts(document.getElementById('books-chart'), options)
                this.chartBooks.render()
            }
        },

        getDashboard2() {
            let loader = this.$loading.show()
            window.axios
                .get('/profile/profile-company/x0y0z0', {
                    params: {
                        param: 'dashboard-admin-2',
                        periode: this.selectedYearPo,
                    },
                })
                .then((response) => {
                    loader.hide()
                    this.dashboard.chartPo.totals = response.data.totals
                    this.dashboard.chartPo.gross = response.data.gross
                    this.dashboard.chartPo.nett = response.data.nett

                    this.chartPurchaseOrder()
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        chartPurchaseOrder() {
            if (this.chartPo) {
                this.chartPo.destroy();
            }

            let options = {
                colors: ['#1A56DB', '#31C48D', '#FDBA8C'],
                series: [
                    {
                        name: 'Gross',
                        color: '#1A56DB',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartPo.gross['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartPo.gross['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartPo.gross['Maret'] },
                            { x: 'April', y: this.dashboard.chartPo.gross['April'] },
                            { x: 'Mei', y: this.dashboard.chartPo.gross['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartPo.gross['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartPo.gross['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartPo.gross['Agustus'] },
                            { x: 'September', y: this.dashboard.chartPo.gross['September'] },
                            { x: 'Oktober', y: this.dashboard.chartPo.gross['Oktober'] },
                            { x: 'November', y: this.dashboard.chartPo.gross['November'] },
                            { x: 'Desember', y: this.dashboard.chartPo.gross['Desember'] },
                        ],
                    },
                    {
                        name: 'Nett',
                        color: '#31C48D',
                        data: [
                            { x: 'Januari', y: this.dashboard.chartPo.nett['Januari'] },
                            { x: 'Februari', y: this.dashboard.chartPo.nett['Februari'] },
                            { x: 'Maret', y: this.dashboard.chartPo.nett['Maret'] },
                            { x: 'April', y: this.dashboard.chartPo.nett['April'] },
                            { x: 'Mei', y: this.dashboard.chartPo.nett['Mei'] },
                            { x: 'Juni', y: this.dashboard.chartPo.nett['Juni'] },
                            { x: 'Juli', y: this.dashboard.chartPo.nett['Juli'] },
                            { x: 'Agustus', y: this.dashboard.chartPo.nett['Agustus'] },
                            { x: 'September', y: this.dashboard.chartPo.nett['September'] },
                            { x: 'Oktober', y: this.dashboard.chartPo.nett['Oktober'] },
                            { x: 'November', y: this.dashboard.chartPo.nett['November'] },
                            { x: 'Desember', y: this.dashboard.chartPo.nett['Desember'] },
                        ],
                    },
                ],
                chart: {
                    type: 'bar',
                    height: '320px',
                    fontFamily: 'Inter, sans-serif',
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '100%',
                        borderRadiusApplication: 'end',
                        borderRadius: 8,
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    style: {
                        fontFamily: 'Inter, sans-serif',
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 1,
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 0,
                    colors: ['transparent'],
                },
                grid: {
                    show: false,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -14,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: false,
                },
                xaxis: {
                    floating: false,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: 'Inter, sans-serif',
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                        },
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: false,
                },
                fill: {
                    opacity: 1,
                },
            }

            if (document.getElementById('po-chart') && typeof ApexCharts !== 'undefined') {
                this.chartPo = new ApexCharts(document.getElementById('po-chart'), options)
                this.chartPo.render()
            }
        },

        printDoc() {
            window.open('profile/profile-document/agreement?id=' + this.form.field.id + '_blank')
        },

        formatTanggal(tanggal) {
            const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']

            const dateObj = new Date(tanggal)
            const hari = dateObj.getDate()
            const bulan = bulanIndo[dateObj.getMonth()]
            const tahun = dateObj.getFullYear()

            return `${hari} ${bulan} ${tahun}`
        },

        generateYears() {
            const currentYear = new Date().getFullYear()
            const startYear = 2024
            for (let year = currentYear; year >= startYear; year--) {
                this.filters.years.push(year)
            }
        },

        async downloadFile() {
            await window
                .axios({
                    url: '/profile/profile-document/download-file',
                    method: 'GET',
                    responseType: 'blob',
                    params: {
                        file: this.form.field.id,
                    },
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'Manual Guide Daftar & Upload Buku Supplier.pdf')
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
