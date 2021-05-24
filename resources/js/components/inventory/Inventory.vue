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
import Ingredients from './content/create_ingredients.vue'
import History from './content/show_history.vue'
export default {
    components:{
        BreadCrumb,
        Create,
        List,
        Show,
        Ingredients,
        History
    },
    mounted() {

    },
    data() {
        return {
        components: [
            {
                title: 'List of Category',
                component: 'List'
            },
            {
                title: 'Create Category',
                component: 'Create'
            },
            {
                title: 'Edit Category',
                component: 'Show'
            },
            {
                title: 'Add Ingredients',
                component: 'Ingredients'
            },
            {
                title: 'Show History',
                component: 'History'
            },
        ],
        active_component: 
            {
                title: 'List of Category',
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