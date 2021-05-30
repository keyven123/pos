<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <v-card v-if="!first_load">
                <v-card-title>Payroll Table</v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="payroll"
                    :search="search"
                    @pagination="paginate"
                    :server-items-length="totalPayrolls"
                    :options.sync="options"
                    :loading="loading"
                    :footer-props="{
                        'items-per-page-options': listSize
                    }"
                >
                <template v-slot:[`item.full_name`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.user.first_name}} {{item.user.last_name}}</div>
                    </div>
                </template>
                <template v-slot:[`item.amount`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.amount|currency}}</div>
                    </div>
                </template>
                <template v-slot:[`item.payroll.payroll_start`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.payroll.payroll_start|myDate}}</div>
                    </div>
                </template>
                <template v-slot:[`item.payroll.payroll_end`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.payroll.payroll_end|myDate}}</div>
                    </div>
                </template>
                <template v-slot:[`item.created_at`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.created_at|completeDate}}</div>
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
    name: 'Create',
    props: {sendToChild: Object},
    mounted() {
        var data = {
            id: this.sendToChild.id
        }
        this.getPayrolls(data)
    },
    data() {
        return {
            search: '',
            filter: {},
            first_load: true,
            headers: [
                {
                    text: 'Employee',
                    align: 'start',
                    filterable: false,
                    value: 'full_name',
                },
                { text: 'Amount', value: 'amount' },
                { text: 'Payroll start', value: 'payroll.payroll_start' },
                { text: 'Payroll end', value: 'payroll.payroll_end' },
                { text: 'Date Generated', value: 'created_at' },
                ],
            totalPayrolls: 0,
            loading: true,
            options: {},
            listSize: [10, 25, 50, 100],
        }
    },
    methods: {
        getPayrolls(data) {
            this.$store.dispatch("getPayroll", data)
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
                this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage, id: this.sendToChild.id}
                this.$store.dispatch("getPayroll", this.filter)
                .then(response => {
                    this.loading = false
                })
            }
        },
        showCreateForm() {
            this.$emit('back', 'Create')
        },
        clearFilter(e) {
            console.log(e)
        },
        filterCategoryByName() {
            this.loading = true
            this.filter.page = 1
            this.filter.search = this.search
            this.$store.dispatch("getPayroll", this.filter)
            .then(response => {
                this.totalPayrolls = response.total;
                this.options.page = response.current_page
                this.loading = false
            })
        },
        
    },
    computed: {
        ...mapGetters({
            payroll: "payroll",
            show_payroll: "show_payroll"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>