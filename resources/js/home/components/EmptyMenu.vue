<template>
    <div role="status" class="max-w-sm animate-pulse">
        <div class="mb-4 h-3 w-52 rounded-full bg-gray-200 dark:bg-gray-700"></div>
        <div class="mb-2.5 h-2 max-w-[360px] rounded-full bg-gray-200 dark:bg-gray-700"></div>
        <div class="mb-2.5 h-2 rounded-full bg-gray-200 dark:bg-gray-700"></div>
        <div class="mb-2.5 h-2 max-w-[330px] rounded-full bg-gray-200 dark:bg-gray-700"></div>
        <div class="mb-2.5 h-2 max-w-[300px] rounded-full bg-gray-200 dark:bg-gray-700"></div>
        <div class="h-2 max-w-[360px] rounded-full bg-gray-200 dark:bg-gray-700"></div>
        <span class="sr-only">Loading...</span>
    </div>
    <slot></slot>
</template>

<script>
export default {
    name: 'EmptyMenu',
}
</script>
