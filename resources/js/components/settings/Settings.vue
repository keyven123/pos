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
import BreadCrumb from '../breadcrumb/BreadCrumb.vue';
import Default from './content/default.vue';
export default {
  name: 'Settings',
  components:{
    BreadCrumb,
    Default,
  },
  
  data() {
    return {
      components: [
         {
            title: 'Default Settings',
            component: 'Default'
         }
      ],
      active_component: 
         {
            title: 'Default Settings',
            component: 'Default'
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