<template>
  <v-app>
      <div class="mx-2">
        <BreadCrumb/>
        <div class="row row-sm">
          <div class="col-xl-12">
                <template v-for="component in components">
                <component
                    :key="component.title" 
                    :is="component.component">
                </component>
                </template>
            </div>
        </div>
      </div>
  </v-app>
</template>

<script>
import BreadCrumb from '../breadcrumb/BreadCrumb.vue'
import Chart from './content/chart.vue'
import Header from './content/header.vue'
import Summary from './content/summary.vue'
export default {
    name: 'Dashboard',
    components:{
        BreadCrumb,
        Chart,
        Summary,
        Header
    },
    mounted() {
        
    },
    data() {
        return {
        components: [
            {
                title: 'Create Category',
                component: 'Header'
            },
            {
                title: 'Chart of Category',
                component: 'Chart'
            },
            {
                title: 'Edit Category',
                component: 'Summary'
            },
        ],
        active_component: 
            {
                title: 'Chart of Category',
                component: 'Chart'
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