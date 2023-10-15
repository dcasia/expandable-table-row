<template>

    <template v-if="hasTableRowData">

        <Column :collapsed="collapsed"/>

        <Column v-for="({ expandableRowData, expandableRowOptions }) of row.resource.fields"
                :collapsed="collapsed"
                :span="expandableRowOptions?.span ?? 0">

            <component
                v-if="expandableRowOptions?.preallocate_column_width"
                :is="'index-' + expandableRowData.component"
                class="h-0 invisible"
                :field="expandableRowData"
            />

            <Collapse :when="!collapsed">

                <component
                    v-if="expandableRowData"
                    :is="'index-' + expandableRowData.component"
                    class="py-2"
                    :class="`text-${ expandableRowData.textAlign }`"
                    :field="expandableRowData"
                />

            </Collapse>

        </Column>

        <Column :collapsed="collapsed"/>

    </template>

</template>

<script>

    import { Collapse } from 'vue-collapsed'
    import Column from './Column.vue'

    export default {
        components: { Column, Collapse },
        props: [ 'row' ],
        data() {
            return {
                collapsed: !this.row.resource
                    .fields
                    .find(({ expandableRowOptions }) => expandableRowOptions?.expanded_by_default === true),
            }
        },
        created() {
            Nova.$on(`collapse-toggle:${ this.row.resource.id.value }`, this.toggle)
        },
        unmounted() {
            Nova.$off(`collapse-toggle:${ this.row.resource.id.value }`, this.toggle)
        },
        computed: {
            hasTableRowData() {
                return !!this.row.resource.fields.find(
                    field => typeof field[ 'expandableRowData' ] !== 'undefined',
                )
            },
        },
        methods: {
            toggle() {
                this.collapsed = !this.collapsed
            },
        },
    }

</script>
