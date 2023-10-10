<template>

    <div class="w-8" v-if="hasTableRowData">

        <div class="toggler w-[24px]" @click="toggleState" >

            <IconArrow
                type="chevron-down"
                class="transition-transform duration-150"
                :class="{ 'rotate-180': collapsed }"/>

        </div>

    </div>

</template>

<script>

    export default {
        props: [ 'row' ],
        data() {
            return {
                collapsed: false,
                Nova,
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

<style lang="scss">

    table[data-testid="resource-table"] tr[dusk$="-row"] > td {
        @apply relative;
    }

    table[data-testid="resource-table"] tr[dusk$="-row"] > td:first-child div.toggler {
        @apply absolute top-0 bottom-0 flex justify-center items-center z-10 right-0;
    }

</style>
