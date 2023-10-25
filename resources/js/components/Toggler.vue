<template>

    <ToolbarButton class="ml-2 mb-1" @click="toggleState" v-if="hasTableRowData">

        <IconArrow
            type="chevron-down"
            class="transition-transform duration-150"
            :class="{ 'rotate-180': !collapsed }"/>

    </ToolbarButton>

</template>

<script>

    export default {
        props: [ 'row' ],
        data() {
            return {
                collapsed: true,
            }
        },
        methods: {
            toggleState() {
                Nova.$emit(`collapse-toggle:${ this.row.resource.id.value }`)
                this.collapsed = !this.collapsed
            },
        },
        computed: {
            hasTableRowData() {
                return !!this.row.resource.fields.find(
                    field => typeof field[ 'expandableRowData' ] !== 'undefined',
                )
            },
        },
    }

</script>
