<template>
<v-app>
    <div class="mx-2">
      <BreadCrumb/>
      <div class="row row-sm">
          <div class="col-xl-12">
                <template v-for="component in components">
                <component 
                    v-if="active_component.component === component.component" 
                    :key="component.title" 
                    :is="component.component"
                    @back="changePage">
                </component>
                </template>
            </div>
        </div>
    </div>
</v-app>
</template>

<script>
import BreadCrumb from '../../breadcrumb/BreadCrumb.vue'
import Interface from './content/interface.vue'
export default {
    name: 'SalesPOS',
    components:{
        BreadCrumb,
        Interface
        // Create,
        // List,
        // Show
    },
    mounted() {

    },
    data() {
        return {
        components: [
            {
                title: 'Order Management',
                component: 'Interface'
            },
        ],
        active_component: 
            {
                title: 'Order Management',
                component: 'Interface'
            }
        }
    },
    methods: {
        changePage(page) {
         this.active_component = this.components.find(component => (component.component) === page)
      },
    }
}
</script>

<style>

</style>