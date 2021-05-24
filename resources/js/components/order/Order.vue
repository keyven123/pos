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
import BreadCrumb from '../breadcrumb/BreadCrumb.vue'
import Create from './content/create.vue'
import List from './content/list.vue'
import Show from './content/show.vue'
export default {
    name: 'Order',
    components:{
        BreadCrumb,
        Create,
        List,
        Show
    },
    mounted() {

    },
    data() {
        return {
        components: [
            {
                title: 'List of Orders',
                component: 'List'
            },
            {
                title: 'Create Orders',
                component: 'Create'
            },
            {
                title: 'Edit Orders',
                component: 'Show'
            },
        ],
        active_component: 
            {
                title: 'List of Orders',
                component: 'List'
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