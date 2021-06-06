<template>
  <div class="row row-sm row-deck">
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card mb-0">
                <div class="card-header bg-transparent pt-0 pd-b-0 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0 pd-t-20">Sales Chart</h4>
                        <v-col
                            class="d-flex p-0"
                            cols="4"
                            sm="3"
                        >
                            <v-select
                            :items="filter_type"
                            v-model="type_filter"
                            label="Type"
                            @change="getChartData()"
                            ></v-select>
                        </v-col>
                        <v-col
                            class="d-flex p-0"
                            cols="4"
                            sm="3"
                        >
                            <v-select
                            :items="filter_date"
                            v-model="date_filter"
                            label="Date"
                            @change="getChartData()"
                            ></v-select>
                        </v-col>
                    </div>
                </div>
                <div class="card-body mb-4 pt-0">
                    <div class="total-revenue">
                        <div>
                            <h4>{{type_filter=='Gross' ? formatCurrency(total.data) : total.data}}</h4>
                            <label><span class="bg-primary"></span>{{type_filter}}</label>
                        </div>
                    </div>
                    <div id="bar" class="sales-bar mt-4">
                        <template v-if="(chartData.length == 1)">
                            <h3 class="pl-4 pt-2">No data</h3>
                            <GChart
                            type="ColumnChart"
                            :data="nochartData"
                            :options="nochartDataOptions"
                        />
                        </template>

                        <template v-if="(chartData.length > 1)">
                            <GChart
                            type="ColumnChart"
                            :data="chartData"
                            :options="chartDataOptions"
                        />
                        </template>
                        
                    </div>
                </div>
            </div>
        </div>
    <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card mb-0">
                <div class="card-header bg-transparent pt-0 pd-b-0 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0 pd-t-20">Sales Chart</h4>
                        <v-col
                            class="d-flex p-0"
                            cols="4"
                            sm="3"
                        >
                            <v-select
                            :items="filter_type2"
                            v-model="type_filter2"
                            label="Type"
                            @change="getFiltered()"
                            ></v-select>
                        </v-col>
                        <v-col
                            class="d-flex p-0"
                            cols="4"
                            sm="3"
                        >
                            <v-select
                            :items="filter_date2"
                            v-model="date_filter2"
                            label="Date"
                            @change="getFiltered()"
                            ></v-select>
                        </v-col>
                    </div>
                </div>
                <div class="card-body mb-4 pt-0">
                    <div class="total-revenue">
                        <div>
                            <h4>{{total2.data|currency}}</h4>
                        </div>
                        <div>
                            <h4>{{type_filter2}}</h4>
                        </div>
                    </div>
                    <div class="mt-4">
                        <template v-if="(chartData2.length == 1)" class="mt-2">
                            <h3 class="pl-4 pt-2">No data</h3>
                            <GChart
                            type="ColumnChart"
                            :data="nochartData"
                            :options="nochartDataOptions"
                        />
                        </template>

                        <template v-if="(chartData2.length > 1)" class="mt-2">
                            <GChart
                            type="ColumnChart"
                            :data="chartData2"
                            :options="chartDataOptions2"
                        />
                        </template>
                        
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    mounted() {
        this.getChartData()
        this.getFiltered()
    },
    data() {
        return {
			chartData: [],
			chartData2: [],
            total: [],
            total2: [],
            chartDataOptions: {
                legend: { position: 'bottom', alignment: 'start' },
                chartArea:{width:'85%', height: '68%'},
                colors: ['#0162e8', '#22c02c', '#ee335e']
            },
            chartDataOptions2: {
                legend: {position: 'none'},
                chartArea:{width:'85%', height: '65%'},
                colors: ['#0162e8', '#22c02c', '#ee335e']
            },
            nochartData: [
                ["Date", "No Data"],
                [moment(Date.now()).format('YYYY/MM/DD'), 0]
            ],
            nochartDataOptions: {
                chartArea:{width:'80%', height: '68%'},
                legend: { position: 'bottom', alignment: 'start' },
            },
            date_filter: '30 Days',
            filter_date: ['30 Days', 'Monthly', 'Yearly'],
            type_filter: 'Gross',
            filter_type: ['Gross', 'Orders', 'Product Sold'],
            date_filter2: 'Today',
            filter_date2: ['Today', 'This Week', 'This Month', 'Last Month', 'This Year'],
            type_filter2: 'Item',
            filter_type2: ['Item', 'Category', 'Employee'],
            filter: {},
            filter2: {}
        }
    },
    methods: {
        ...mapActions({
            getAllChart: "getAllChart",
            getFilterData: "getFilterData"
        }),
        formatCurrency(value) {
            let val = (value/1).toFixed(2).replace('.', '.')
            return "₱" + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        getChartData() {
            this.filter = {...this.filter, type: this.type_filter, date: this.date_filter}
            this.getAllChart(this.filter)
            .then(response => {
				this.chartData = response.chart_data
				this.total = response.total
            })
        },
        getFiltered() {
            this.filter2 = {...this.filter2, type: this.type_filter2, date: this.date_filter2}
            this.getFilterData(this.filter2)
            .then(response => {
                this.chartData2 = []
                this.total2 = response.total2
                var data = response.chart_data2
                var colors = ['#FF0000','#FF7F00', '#FFFF00', '#00FF00', '#0000FF', '#4B0082', '#9400D3', '#B87333', '#703593', '#76A7FA']
                this.chartData2.push([data[0][0], data[0][1], { role: 'style' }])
                for (var i = 1; i < data.length; i++) {
                    this.chartData2.push([data[i][0], data[i][1], colors[i-1]])
                }
            })
        }
    },
    computed: {
        ...mapGetters({
            getChart: "getChart",
            getFilter: "getFilter"
        })
    }
}
</script>

<style>

</style>