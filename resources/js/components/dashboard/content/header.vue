<template>
  <div class="row row-sm">
    <div class="col-xl-3 col-lg-3 col-md-6 col-xm-12">
        <div class="card overflow-hidden mb-0 sales-card bg-primary-gradient">
            <div class="pl-3 pt-3 pr-3 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">TODAY ORDERS</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{order.order_count}}</h4>
                            <p class="mb-0 tx-12 text-white op-7">Compared yesterday</p>
                        </div>
                        <span class="float-right my-auto ml-auto">
                            <template v-if="countCompare > 0"><i class="fas fa-arrow-circle-up text-white"></i></template>
                            <template v-if="countCompare < 0"><i class="fas fa-arrow-circle-down text-white"></i></template>
                            <span class="text-white op-7">{{countCompare}}</span>
                        </span>
                    </div>
                </div>
            </div>
            <span>
                <v-sparkline
                    :value="daily_orders"
                    :gradient="gradient"
                    :smooth="radius || false"
                    :padding="padding"
                    :line-width="width"
                    height="30"
                    :stroke-linecap="lineCap"
                    :gradient-direction="gradientDirection"
                    :fill="fill"
                    :type="type"
                    :auto-line-width="autoLineWidth"
                    auto-draw
                ></v-sparkline>
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-xm-12">
        <div class="card overflow-hidden mb-0 sales-card bg-danger-gradient">
            <div class="pl-3 pt-3 pr-3 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">TODAY EARNINGS</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{order.today_earnings|currency}}</h4>
                            <p class="mb-0 tx-12 text-white op-7">Compared yesterday</p>
                        </div>
                        <span class="float-right my-auto ml-auto">
                            <template v-if="earningsCompare > 0"><i class="fas fa-arrow-circle-up text-white"></i></template>
                            <template v-if="earningsCompare < 0"><i class="fas fa-arrow-circle-down text-white"></i></template>
                            <span class="text-white op-7">{{earningsCompare}}</span>
                        </span>
                    </div>
                </div>
            </div>
            <span>
                <v-sparkline
                    :value="daily_earnings"
                    :gradient="gradient"
                    :smooth="radius || false"
                    :padding="padding"
                    :line-width="width"
                    height="30"
                    :stroke-linecap="lineCap"
                    :gradient-direction="gradientDirection"
                    :fill="fill"
                    :type="type"
                    :auto-line-width="autoLineWidth"
                    auto-draw
                ></v-sparkline>
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-xm-12">
        <div class="card overflow-hidden mb-0 sales-card bg-success-gradient">
            <div class="pl-3 pt-3 pr-3 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">TOTAL EARNINGS</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{total.total_earnings|currency}}</h4>
                            <p class="mb-0 tx-12 text-white op-7">Compared to last month</p>
                        </div>
                        <span class="float-right my-auto ml-auto">
                            <template v-if="earningsLastMonth > 0"><i class="fas fa-arrow-circle-up text-white"></i></template>
                            <template v-if="earningsLastMonth < 0"><i class="fas fa-arrow-circle-down text-white"></i></template>
                            <span class="text-white op-7">{{earningsLastMonth|currency}}</span>
                        </span>
                    </div>
                </div>
            </div>
            <span>
                <v-sparkline
                    :value="weekly_earnings"
                    :gradient="gradient"
                    :smooth="radius || false"
                    :padding="padding"
                    :line-width="width"
                    height="30"
                    :stroke-linecap="lineCap"
                    :gradient-direction="gradientDirection"
                    :fill="fill"
                    :type="type"
                    :auto-line-width="autoLineWidth"
                    auto-draw
                ></v-sparkline>
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-xm-12">
        <div class="card overflow-hidden mb-0 sales-card bg-warning-gradient">
            <div class="pl-3 pt-3 pr-3 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">PRODUCT SOLD</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{total.product_sold ? total.product_sold : 0}}</h4>
                            <p class="mb-0 tx-12 text-white op-7">Compared to last month</p>
                        </div>
                        <span class="float-right my-auto ml-auto">
                            <template v-if="compareProductSold > 0"><i class="fas fa-arrow-circle-up text-white"></i></template>
                            <template v-if="compareProductSold < 0"><i class="fas fa-arrow-circle-down text-white"></i></template>
                            <span class="text-white op-7">{{compareProductSold}}</span>
                        </span>
                    </div>
                </div>
            </div>
            <span>
                <v-sparkline
                    :value="weekly_quantity"
                    :gradient="gradient"
                    :smooth="radius || false"
                    :padding="padding"
                    :line-width="width"
                    height="30"
                    :stroke-linecap="lineCap"
                    :gradient-direction="gradientDirection"
                    :fill="fill"
                    :type="type"
                    :auto-line-width="autoLineWidth"
                    auto-draw
                ></v-sparkline>
            </span>
        </div>
    </div>
</div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
const gradients = [
    ['#222'],
    ['#42b3f4'],
    ['red', 'orange', 'yellow'],
    ['purple', 'violet'],
    ['#00c6ff', '#F0F', '#FF0'],
    ['#f72047', '#ffd200', '#1feaea'],
  ]
export default {
    mounted() {
        this.getSumarryData()
        this.getSparkLine()
    },
    data() {
        return {
            order: [],
            total: [],
            order_yesterday: [],
            total_last_month: [],
            total_this_month: [],
            daily_orders: [],
            daily_earnings: [],
            weekly_earnings: [],
            weekly_quantity: [],
            width: 2,
            radius: 2,
            padding: 8,
            lineCap: 'round',
            gradient: gradients[5],
            gradientDirection: 'top',
            gradients,
            fill: true,
            type: 'trend',
            autoLineWidth: false,
        }
    },
    methods: {
        ...mapActions({
            getAllData: "getAllData",
            getAllSparkLine: "getAllSparkLine"
        }),
        async getSumarryData() {
            this.getAllData()
            .then(response => {
                this.order = response.order
                this.total = response.total
                this.order_yesterday = response.order_yesterday
                this.total_last_month = response.total_last_month
                this.total_this_month = response.total_this_month
            })
        },
        getSparkLine() {
            this.getAllSparkLine()
            .then(response => {
                this.daily_orders = response.daily_orders
                this.daily_earnings = response.daily_earnings
                this.weekly_earnings = response.weekly_earnings
                this.weekly_quantity = response.weekly_quantity
            })
        }
    },
    computed: {
        ...mapGetters({
            getData: "getData",
            getSparkline: "getSparkline"
        }),
        countCompare() {
            return  parseInt(this.order.order_count) - parseInt(this.order_yesterday.order_count)
        },
        earningsCompare() {
            if(this.order.today_earnings == null || this.order_yesterday.today_earnings == null) {
                return this.order.today_earnings
            } else {
                return parseFloat(this.order.today_earnings) - parseFloat(this.order_yesterday.today_earnings)
            }
        },
        earningsLastMonth() {
            if(this.total_last_month.total_earnings == null || this.total_this_month.total_earnings == null) {
                return this.total_this_month.total_earnings
            } else {
                return parseFloat(this.total_this_month.total_earnings) - parseFloat(this.total_last_month.total_earnings)
            }
        },
        compareProductSold() {
            if(this.total_this_month.product_sold == null || this.total_last_month.product_sold == null) {
                return this.total_this_month.product_sold
            } else {
                return  parseInt(this.total_this_month.product_sold) - parseInt(this.total_last_month.product_sold)
            }
        }
    }
}
</script>

<style>

</style>