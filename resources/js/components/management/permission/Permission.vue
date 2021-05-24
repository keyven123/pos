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
import List from './content/list.vue'
import Create from './content/create.vue'
import Show from './content/show.vue'
export default {
  name: 'Permission',
  components:{
    BreadCrumb,
    List,
    Create,
    Show
  },
  
  data() {
    return {
      components: [
         {
            title: 'List of Permissions',
            component: 'List'
         },
         {
            title: 'Create Permissions',
            component: 'Create'
         },
         {
            title: 'Edit Permissions',
            component: 'Show'
         }
      ],
      active_component: 
         {
            title: 'List of Permissions',
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