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
import List from './content/list.vue'
// import Show from './content/show.vue'
export default {
    name: 'Employee',
    components:{
        BreadCrumb,
        List,
        // Show,
        // Attendance
    },
    mounted() {
        
    },
    data() {
        return {
        components: [
            {
                title: 'List of Employee',
                component: 'List'
            },
            // {
            //     title: 'Employee Details',
            //     component: 'Show'
            // },
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