<template>
    <div class="w-100 h-100 mx-auto overflow-hidden rounded-lg bg-white shadow-md">
        <div class="z-50 border-b border-gray-200 p-4">
            <nav aria-label="Breadcrumb" class="flex justify-start">
                <ol class="flex overflow-hidden rounded-lg border border-gray-200 text-gray-600">
                    <li class="flex items-center">
                        <a href="#" class="flex h-10 items-center gap-1.5 bg-gray-100 px-4 transition hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>

                            <span class="ms-1.5 text-xs font-medium"> Kategory Buku </span>
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="p-6">
            <table id="default-table">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { DataTable } from 'simple-datatables'

let dataTable
export default {
    mounted() {
        this.getData()

        dataTable = new DataTable('#default-table', {
            sortable: true,
            data: {
                headings: [
                    { text: 'kode', data: 'id' },
                    { text: 'kategori', data: 'description' },
                ],
            },
        })
    },

    methods: {
        getData() {
            let loader = this.$loading.show()
            window.axios
                .get('/report/category-books')
                .then((response) => {
                    dataTable.data.data = []
                    dataTable.insert(response.data.data)

                    loader.hide()
                })
                .catch((e) => {
                    console.error(e)
                    loader.hide()
                })
        },
    },
}
</script>
