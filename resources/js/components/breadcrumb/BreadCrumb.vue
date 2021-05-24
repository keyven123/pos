<template>
  <div>
      <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between" style="margin-bottom: 5px">
            <div class="left-content">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{breadcrumb.name}}</h2>
                    <p class="mg-b-0">{{breadcrumb.description}}</p>
                </div>
            </div>
            <div class="main-dashboard-header-right" v-if="breadcrumb.name !='Sales POS'">
                <div>
                    <div class="main-star">
                        <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <span></span>
                    </div>
                </div>
                <!-- <div>
                    <label class="tx-13">Online Sales</label>
                    <h5>563,275</h5>
                </div>
                <div>
                    <label class="tx-13">Offline Sales</label>
                    <h5>783,675</h5>
                </div> -->
            </div>
        </div>
      <!-- /breadcrumb -->
  </div>
</template>

<script>
export default {
    mounted() {
        this.breadcrumb = this.$route
    },
    data() {
        return {
            breadcrumb: [],

        }
    }

}
</script>

<style>
</style>