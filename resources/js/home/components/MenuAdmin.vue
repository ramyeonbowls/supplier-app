<template>
    <ul class="flex max-h-[80vh] flex-col overflow-y-auto">
        <router-link :to="{ name: 'home' }">
            <li class="group flex items-center gap-3 rounded-md p-2 hover:cursor-pointer hover:bg-indigo-500 focus:bg-indigo-600 active:bg-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-5 stroke-svg-icon-color group-hover:stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>

                <p class="text-sm font-semibold text-slate-500 group-hover:text-slate-50">Dashboard</p>
            </li>
        </router-link>
        <router-link :to="{ name: 'approval_book' }">
            <li class="group flex items-center gap-3 rounded-md p-2 hover:cursor-pointer hover:bg-indigo-500 focus:bg-indigo-600 active:bg-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-5 stroke-svg-icon-color group-hover:stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                </svg>

                <p class="text-sm font-semibold text-slate-500 group-hover:text-slate-50">Approval Buku</p>
            </li>
        </router-link>
        <router-link :to="{ name: 'approval_client' }">
            <li class="group flex items-center gap-3 rounded-md p-2 hover:cursor-pointer hover:bg-indigo-500 focus:bg-indigo-600 active:bg-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-5 stroke-svg-icon-color group-hover:stroke-white">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
                    />
                </svg>

                <p class="text-sm font-semibold text-slate-500 group-hover:text-slate-50">Approval Client</p>
            </li>
        </router-link>
        <router-link :to="{ name: 'report_supplier' }">
            <li class="group flex items-center gap-3 rounded-md p-2 hover:cursor-pointer hover:bg-indigo-500 focus:bg-indigo-600 active:bg-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-5 stroke-svg-icon-color group-hover:stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                </svg>

                <p class="text-sm font-semibold text-slate-500 group-hover:text-slate-50">Report Supplier</p>
            </li>
        </router-link>
        <router-link :to="{ name: 'report_distributor' }">
            <li class="group flex items-center gap-3 rounded-md p-2 hover:cursor-pointer hover:bg-indigo-500 focus:bg-indigo-600 active:bg-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-5 stroke-svg-icon-color group-hover:stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                </svg>

                <p class="text-sm font-semibold text-slate-500 group-hover:text-slate-50">Report Distributor</p>
            </li>
        </router-link>
        <router-link :to="{ name: 'encrypt_file' }">
            <li class="group flex items-center gap-3 rounded-md p-2 hover:cursor-pointer hover:bg-indigo-500 focus:bg-indigo-600 active:bg-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-5 stroke-svg-icon-color group-hover:stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>

                <p class="text-sm font-semibold text-slate-500 group-hover:text-slate-50">Enkripsi File</p>
            </li>
        </router-link>
        <router-link :to="{ name: 'upload_po' }">
            <li class="group flex items-center gap-3 rounded-md p-2 hover:cursor-pointer hover:bg-indigo-500 focus:bg-indigo-600 active:bg-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-5 stroke-svg-icon-color group-hover:stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>

                <p class="text-sm font-semibold text-slate-500 group-hover:text-slate-50">Upload PO</p>
            </li>
        </router-link>
    </ul>
    <slot></slot>
</template>

<script>
export default {
    name: 'MenuAdmin',
}
</script>
