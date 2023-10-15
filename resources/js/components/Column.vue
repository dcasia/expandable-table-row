<template>

    <td :colspan="span" :class="{ 'dark:border-gray-700 dark:bg-gray-800': collapsed, 'border-t border-gray-600 bg-gray-50 dark:bg-[rgba(var(--colors-gray-900),var(--tw-bg-opacity))]': !collapsed }"
        class="px-2 whitespace-nowrap group-hover:bg-gray-50 dark:group-hover:bg-gray-900 border-t-gray-200 dark:border-t-gray-700 transition-all duration-100 bg-opacity-30">
        <slot/>
    </td>

</template>

<script>

    export default {
        props: [ 'collapsed', 'span' ],
    }

</script>
