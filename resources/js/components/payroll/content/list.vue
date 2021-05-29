<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>List of Payroll</h3>
                <v-btn
                color="primary"
                class="mb-2 ml-6"
                fab
                x-small
                @click="showCreateForm"
                title="Generate Payroll"
                >
                <v-icon>
                    mdi-file-document
                </v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <v-text-field
                v-model="search"
                append-icon=""
                label="Search Payroll"
                single-line
                hide-details
                clearable
                @click:clear="clearFilter"
                ></v-text-field>
                <v-btn
                    class="margin-top-16"
                    color="info"
                    fab
                    x-small
                    dark
                    @click="filterBy"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="payrolls"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalPayrolls"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:[`item.warning_level`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.warning_level|unit}} {{item.unit}}</div>
                </div>
            </template>
            <template v-slot:[`item.created_at`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.created_at|completeDate}}</div>
                </div>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <button
                    class="btn btn-primary btn-sm" 
                    @click="selectPayroll(item)"><i class="fas fa-edit"></i></button>
            </template>
            </v-data-table>
        </v-card>
    </div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
mounted() {
    this.getPayrolls()
    this.$store.dispatch("authenticate")
},
data() {
    return {
        search: '',
        filter: {},
        first_load: true,
        headers: [
            {
                text: 'Description',
                align: 'start',
                filterable: false,
                value: 'description',
            },
            { text: 'Total amount', value: 'amount' },
            { text: 'Payroll start', value: 'payroll_start' },
            { text: 'Payroll end', value: 'payroll_end' },
            { text: 'Date Generated', value: 'created_at' },
            { text: "Actions", value: "actions" }
            ],
        totalPayrolls: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getAllPayrolls: "getAllPayrolls" ,
        showPayroll: "showPayroll"

    }),
    getPayrolls() {
        this.getAllPayrolls()
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
            this.getAllPayrolls(this.filter)
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
    filterBy() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllPayrolls(this.filter)
        .then(response => {
            this.totalPayrolls = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectPayroll(payroll) {
        this.showPayroll(payroll)
        .then(() => {
            this.$emit("back", "Show");
        });
    },
},
    computed: {
        ...mapGetters({
            payrolls: "payrolls",
            userAuthentication: "userAuthentication"
        }),
    }
}
</script>

<style>

</style>