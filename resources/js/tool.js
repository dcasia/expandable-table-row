import Row from './components/Row.vue'
import Toggler from './components/Toggler.vue'
import { createVNode, render } from 'vue'

Nova.booting(app => {

    app.mixin({
        data() {
            return {
                container: null,
                toDestroy: [],
            }
        },
        unmounted() {

            for (const element of this.toDestroy) {
                render(null, element)
            }

        },
        mounted() {

            if (this._.type?.__file?.endsWith('ResourceTableRow.vue')) {

                const togglerContainer = document.createElement('div')
                const container = this.container = document.createElement('tr')

                container.classList.add('expandable-table-row')
                togglerContainer.classList.add('inline-flex', 'align-middle')

                this.$watch('hasTableRowData', () => {
                    container.style.borderWidth = this.hasTableRowData ? '0' : null
                }, { immediate: true })

                const rowId = this.resource.id.value

                const element = document.querySelector(`table[data-testid="resource-table"] tr[dusk="${ rowId }-row"]`)
                const checkbox = document.querySelector(`table[data-testid="resource-table"] tr[dusk="${ rowId }-row"] > td`)

                if (element) {

                    checkbox.appendChild(togglerContainer)

                    element.insertAdjacentElement('afterend', container)
                    element.classList.add('expandable-table-row')

                    const rowVNode = createVNode(Row, { row: this, hasTableRowData: this.hasTableRowData })
                    const togglerVNode = createVNode(Toggler, { row: this, hasTableRowData: this.hasTableRowData })

                    rowVNode.appContext = app._context
                    togglerVNode.appContext = app._context

                    render(rowVNode, container)
                    render(togglerVNode, togglerContainer)

                    this.toDestroy.push(container, togglerContainer)

                }

            }

        },
        computed: {
            hasTableRowData() {
                if (this.resource) {
                    return !!this.resource.fields.find(
                        field => typeof field[ 'expandableRowData' ] !== 'undefined',
                    )
                }
            },
        },
    })

})
