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
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"
                    />
                </svg>

                <p class="text-sm font-semibold text-slate-500 group-hover:text-slate-50">Approval Buku</p>
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
