<template>

    <Icon type="chevron-down"
          height="12"
          class="ml-2 transition-all"
          :class="{ 'rotate-180': collapsed }"
          @click="toggleState"
    />

</template>

<script>

    export default {
        props: [ 'toolbar' ],
        data() {
            return {
                collapsed: false,
                Nova,
            }
        },
        methods: {
            toggleState() {
                Nova.$emit(`collapse-toggle:${ this.toolbar.resource.id.value }`)
                this.collapsed = !this.collapsed
            },
        },
    }

</script>

<style>

    table[data-testid="resource-table"] tr[dusk$="-row"] > td:first-child {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 53px;
        width: 100%;
    }

</style>
