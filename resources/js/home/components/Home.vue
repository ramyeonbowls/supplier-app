<template>
    <!-- <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
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
            <table id="default-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                Name
                                <svg class="ms-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th data-type="date" data-format="YYYY/DD/MM">
                            <span class="flex items-center">
                                Release Date
                                <svg class="ms-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                NPM Downloads
                                <svg class="ms-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Growth
                                <svg class="ms-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Flowbite</td>
                        <td>2021/25/09</td>
                        <td>269000</td>
                        <td>49%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">React</td>
                        <td>2013/24/05</td>
                        <td>4500000</td>
                        <td>24%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Angular</td>
                        <td>2010/20/09</td>
                        <td>2800000</td>
                        <td>17%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Vue</td>
                        <td>2014/12/02</td>
                        <td>3600000</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Svelte</td>
                        <td>2016/26/11</td>
                        <td>1200000</td>
                        <td>57%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Ember</td>
                        <td>2011/08/12</td>
                        <td>500000</td>
                        <td>44%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Backbone</td>
                        <td>2010/13/10</td>
                        <td>300000</td>
                        <td>9%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">jQuery</td>
                        <td>2006/28/01</td>
                        <td>6000000</td>
                        <td>5%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Bootstrap</td>
                        <td>2011/19/08</td>
                        <td>1800000</td>
                        <td>12%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Foundation</td>
                        <td>2011/23/09</td>
                        <td>700000</td>
                        <td>8%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Bulma</td>
                        <td>2016/24/10</td>
                        <td>500000</td>
                        <td>7%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Next.js</td>
                        <td>2016/25/10</td>
                        <td>2300000</td>
                        <td>45%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Nuxt.js</td>
                        <td>2016/16/10</td>
                        <td>900000</td>
                        <td>50%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Meteor</td>
                        <td>2012/17/01</td>
                        <td>1000000</td>
                        <td>10%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Aurelia</td>
                        <td>2015/08/07</td>
                        <td>200000</td>
                        <td>20%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Inferno</td>
                        <td>2016/27/09</td>
                        <td>100000</td>
                        <td>35%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Preact</td>
                        <td>2015/16/08</td>
                        <td>600000</td>
                        <td>28%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Lit</td>
                        <td>2018/28/05</td>
                        <td>400000</td>
                        <td>60%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Alpine.js</td>
                        <td>2019/02/11</td>
                        <td>300000</td>
                        <td>70%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Stimulus</td>
                        <td>2018/06/03</td>
                        <td>150000</td>
                        <td>25%</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap font-medium text-gray-900 dark:text-white">Solid</td>
                        <td>2021/05/07</td>
                        <td>250000</td>
                        <td>80%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> -->
    <div class="grid h-screen place-content-center rounded-md bg-white px-4">
        <div class="text-center">
            <h1 class="text-9xl font-black text-gray-200">Coming Soon</h1>

            <p class="text-2xl font-bold tracking-tight text-gray-900 sm:text-4xl">Update soon!</p>

            <p class="mt-4 text-gray-500">We still build this page.</p>

            <a href="#" class="mt-6 inline-block rounded bg-indigo-600 px-5 py-3 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring"> Go Back Home </a>
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
