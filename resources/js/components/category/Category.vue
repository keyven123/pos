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
import { mapGetters, mapActions } from 'vuex'
import BreadCrumb from '../breadcrumb/BreadCrumb.vue'
import Create from './content/create.vue'
import List from './content/list.vue'
import Show from './content/show.vue'
export default {
    name: 'Category',
    components:{
        BreadCrumb,
        List,
        Show,
        Create
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
    },
}
</script>