import Row from './components/Row.vue'
import Toggler from './components/Toggler.vue'
import { createVNode, render } from 'vue'

Nova.booting(app => {

    app.mixin({
        data() {
            return {
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

                const container = document.createElement('tr')

                container.classList.add('expandable-table-row')
                container.style.borderWidth = '0'

                const rowId = this.resource.id.value

                const element = document.querySelector(`table[data-testid="resource-table"] tr[dusk="${ rowId }-row"]`)
                const checkbox = document.querySelector(`table[data-testid="resource-table"] tr[dusk="${ rowId }-row"] > td`)

                if (element) {

                    element.insertAdjacentElement('afterend', container)

                    const rowVNode = createVNode(Row, { row: this })
                    const togglerVNode = createVNode(Toggler, { row: this })

                    rowVNode.appContext = app._context
                    togglerVNode.appContext = app._context

                    render(rowVNode, container)
                    render(togglerVNode, checkbox)

                    this.toDestroy.push(container, checkbox)

                }

            }

        },
    })

})
