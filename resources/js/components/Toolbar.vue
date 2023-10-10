<template>

    <td class="px-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
        :class="{ 'py-0': collapsed, 'py-0': !collapsed }"
        @click="collapsed = !collapsed">
    </td>

    <td v-for="field of toolbar.resource.fields"
        :class="{ 'py-0': collapsed, 'py-2': !collapsed }"
        class="px-2 whitespace-nowrap transition-all duration-250 cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900 overflow-hidden">

        <Collapse :when="collapsed">

            <component
                v-if="field.expandableRowData"
                :is="'index-' + field.expandableRowData.component"
                :class="`text-${ field.expandableRowData.textAlign }`"
                :field="field.expandableRowData"
            />

        </Collapse>


    </td>

    <td class="px-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
        :class="{ 'py-0': collapsed, 'py-0': !collapsed }">
    </td>

</template>

<script>

    import { computed, reactive, ref } from 'vue'
    import { useLocalization } from '@/composables/useLocalization'
    import { useActions } from '@/composables/useActions'
    import { Collapse } from 'vue-collapsed'

    export default {
        components: { Collapse },
        props: [ 'toolbar' ],
        emits: [ 'actionExecuted' ],
        created() {

            Nova.$on(`collapse-toggle:${ this.toolbar.resource.id.value }`, () => {
                this.collapsed = !this.collapsed
            })

        },
        data() {
            return {
                collapsed: true,
            }
        },
    }

</script>

<style lang="scss">

    #expandable-table-row {

        border-width: 0;
        //visibility: collapse;

    }

</style>
