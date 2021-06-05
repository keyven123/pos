<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <div class="col-md-12" v-if="first_load">
                <form @submit.prevent="generatePayroll()">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-4">
                            <label class="col-form-label pt-0">Description</label>
                                <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('description')}" type="text" placeholder="Description" v-model="description">
                                <label v-if="errors.hasOwnProperty('description')" class="text-danger">{{errors.description[0]}}</label>
                            </div>
                            <div class="col-4">
                            <label class="col-form-label pt-0">Payroll Start</label>
                                <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('payroll_start')}" type="date" :max="date_restriction" placeholder="Start date of payroll" v-model="payroll_start">
                                <label v-if="errors.hasOwnProperty('payroll_start')" class="text-danger">{{errors.payroll_start[0]}}</label>
                            </div>
                            <div class="col-4">
                            <label class="col-form-label pt-0">Payroll End</label>
                                <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('payroll_end')}" @click="minimumTo(payroll_start)" type="date" :min="min_date_restriction" :max="date_restriction" placeholder="End date of payroll" v-model="payroll_end">
                                <label v-if="errors.hasOwnProperty('payroll_end')" class="text-danger">{{errors.payroll_end[0]}}</label>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" style="color: #fff">Submit</button>
                </form>
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
    mounted() {
        this.dateRestriction()
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
            description: null,
            payroll_start: null,
            payroll_end: null,
            errors: {},
            date_restriction: '',
            min_date_restriction: null,
            id: '',
        }
    },
    methods: {
        ...mapActions({
            createPayroll: "createPayroll"
        }),
        dateRestriction(){
            this.date_restriction = new Date().toJSON().slice(0,10)
        },
        minimumTo(data) {
            return this.min_date_restriction = data
        },
        generatePayroll() {
            const data = {
                description: this.description,
                payroll_start: this.payroll_start,
                payroll_end: this.payroll_end,
            }
            this.createPayroll(data)
            .then(response => {
                if (response.success) {
                    this.description =  null
                    this.payroll_start =  null
                    this.payroll_end = null,
                    this.errors = {}
                    Swal.fire({
                        icon: response.alert_type,
                        title: response.message,
                        showConfirmButton: true,
                    })
                    this.id = response.data.id
                    var data = {
                        id: response.data.id
                    }
                    this.$store.dispatch("getPayroll", data)
                    .then(response => {
                        this.loading = false;
                        this.totalPayrolls = response.total;
                        this.options = {...this.options, itemsPerPage: response.per_page}
                        setTimeout(() => {
                            this.first_load = false
                        }, 1000)
                    })
                } else {
                    Swal.fire('Error', response.message , 'error')
                }
            }).catch(error => {
                this.errors = error.response.data.errors
                Swal.fire('Error', error.response.data.message , 'error')
            })
        },
        paginate(e) {
            if(e.itemsLength !== 0 && !this.first_load) {
                this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage, id: this.id}
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
            payroll: "payroll"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>