<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="z-50 border-b border-gray-200 p-4">
            <nav aria-label="Breadcrumb" class="flex justify-start">
                <ol class="flex overflow-hidden rounded-lg border border-gray-200 text-gray-600">
                    <li class="flex items-center">
                        <a href="#" class="flex h-10 items-center gap-1.5 bg-gray-100 px-4 transition hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>

                            <span class="ms-1.5 text-xs font-medium"> Home </span>
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-5 gap-2 lg:grid-cols-5 lg:gap-6">
                <div class="h-32">
                    <article class="rounded-lg border border-gray-100 bg-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                    </svg>

                                    <p class="whitespace-nowrap text-sm">Draft</p>
                                </span>

                                <p class="text-2xl font-medium text-gray-900">20 Buku</p>
                            </div>
                        </div>

                        <div class="mt-1 flex gap-1 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>

                            <p class="flex gap-2 text-xs">
                                <span class="font-medium"> 67.81% </span>

                                <span class="text-gray-500"> Since last week </span>
                            </p>
                        </div>
                    </article>
                </div>
                <div class="h-32">
                    <article class="rounded-lg border border-gray-100 bg-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="inline-flex items-center justify-center rounded-full bg-orange-100 px-2.5 py-0.5 text-orange-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 15.75-2.489-2.489m0 0a3.375 3.375 0 1 0-4.773-4.773 3.375 3.375 0 0 0 4.774 4.774ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                    <p class="whitespace-nowrap text-sm">Review</p>
                                </span>

                                <p class="text-2xl font-medium text-gray-900">20 Buku</p>
                            </div>
                        </div>

                        <div class="mt-1 flex gap-1 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>

                            <p class="flex gap-2 text-xs">
                                <span class="font-medium"> 67.81% </span>

                                <span class="text-gray-500"> Since last week </span>
                            </p>
                        </div>
                    </article>
                </div>
                <div class="h-32 rounded-lg bg-gray-200"></div>
                <div class="h-32 rounded-lg bg-gray-200"></div>
                <div class="h-32 rounded-lg bg-gray-200"></div>
            </div>
        </div>
    </div>
</template>

<script>
import { DataTable } from 'simple-datatables'

export default {
    mounted() {
        // const dataTable = new DataTable('#default-table')
    },
}
</script>
