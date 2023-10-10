import Toolbar from './components/Toolbar.vue'
import Toggler from './components/Toggler.vue'
import { createVNode, render } from 'vue'

Nova.booting(app => {

    app.mixin({
        mounted() {

            if (this._.type?.__file?.endsWith('ResourceTableRow.vue')) {

                const container = document.createElement('tr')
                container.id = 'expandable-table-row'

                const togglerContainer = document.createElement('div')
                togglerContainer.id = 'expandable-table-row'

                const rowId = this.resource.id.value

                const element = document.querySelector(`table[data-testid="resource-table"] tr[dusk="${ rowId }-row"]`)
                const checkbox = document.querySelector(`table[data-testid="resource-table"] tr[dusk="${ rowId }-row"] > td`)

                if (element) {

                    element.insertAdjacentElement('afterend', container)
                    checkbox.insertAdjacentElement('beforeend', togglerContainer)

                    const vnode = createVNode(Toolbar, { toolbar: this })
                    vnode.appContext = app._context

                    render(vnode, container)

                    const vnodeToggler = createVNode(Toggler, { toolbar: this })
                    vnodeToggler.appContext = app._context

                    render(vnodeToggler, togglerContainer)

                }

            }

        },
    })

})
