<template>

    <template v-if="hasTableRowData">

        <Column :collapsed="collapsed"/>

        <Column v-for="({ expandableRowData, expandableRowOptions }) of fields"
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
            fields() {

                const fields = []

                let maxColumns = this.row.resource.fields.length
                let skip = 0
                let total = 0

                for (const field of this.row.resource.fields) {

                    if (skip) {
                        skip--
                        continue
                    }

                    const span = field.expandableRowOptions?.span || 0

                    if (span) {
                        skip = span - 1
                    }

                    fields.push(field)
                    total += span

                }

                /**
                 * Inject last column (actions column) only if there are room
                 */
                if (total < maxColumns) {
                    fields.push({ span: 0 })
                }

                return fields

            },
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
