<template>

    <td :class="{ 'border-gray-700 dark:bg-gray-800': collapsed, 'border-b border-t border-gray-600 dark:bg-gray-800': !collapsed }"
        class="px-2 whitespace-nowrap group-hover:bg-gray-50 dark:group-hover:bg-gray-900 border-t-gray-700 transition-all duration-100">
        <slot/>
    </td>

</template>

<script>

    export default {
        props: [ 'collapsed' ],
    }

</script>
