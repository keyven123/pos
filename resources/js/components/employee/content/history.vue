<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <div class="col-12 p-3">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <v-card-title>
                <h3>Payroll Histories for {{employee.first_name}} {{employee.last_name}}</h3>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="payrollHistories"
                @pagination="paginate"
                :server-items-length="totalPayrolls"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:[`item.amount`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.amount|currency}}</div>
                </div>
            </template>
            <template v-slot:[`item.payroll_start`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.payroll_start|myDate}}</div>
                </div>
            </template>
            <template v-slot:[`item.payroll_end`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.payroll_end|myDate}}</div>
                </div>
            </template>
            <template v-slot:[`item.created_at`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.created_at|myDate}}</div>
                </div>
            </template>
            </v-data-table>
        </v-card>
    </div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
name: "History",
props: {
    sendToChild: Object,
},
mounted() {
    var data = {
        id: this.sendToChild.id
    }
    this.getPayrolls(data)
},
data() {
    return {
        filter: {},
        first_load: true,
        headers: [
            { text: 'Amount', value: 'amount' },
            { text: 'Payroll start', value: 'payroll_start' },
            { text: 'Payroll end', value: 'payroll_end' },
            { text: 'Created at', value: 'created_at' },
            ],
        totalPayrolls: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        showPayrollHistory: "showPayrollHistory" ,

    }),
    getPayrolls(data) {
        this.showPayrollHistory(data)
        .then(response => {
            this.loading = false;
            this.totalPayrolls = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.showPayrollHistory(this.filter)
            .then(response => {
                this.loading = false
            })
        }
    },
},
    computed: {
        ...mapGetters({
            payrollHistories: "payrollHistories",
            employee: "employee"
        }),
    }
}
</script>

<style>

</style>