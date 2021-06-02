<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <div class="col-12 p-3">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <v-card-title>
                <h3>Attendance Approval for {{employee.first_name}} {{employee.last_name}}</h3>
            </v-card-title>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-1 d-flex justify-content-center">
                        <div class="d-flex align-items-center"><h4>Date:</h4></div>
                    </div>
                    <div class="col-md-5">
                        <v-sheet tile height="54" class="d-flex">
                        <v-select
                            v-model="month"
                            :items="months"
                            @change="changeMonth()"
                            dense
                            outlined
                            hide-details
                            class="ma-2"
                            label="month"
                        ></v-select>
                        <v-select
                            v-model="year"
                            :items="years"
                            @change="changeMonth()"
                            dense
                            outlined
                            hide-details
                            class="ma-2"
                            label="year"
                        ></v-select>
                        </v-sheet>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <v-data-table
                    :headers="headers"
                    :items="attendances"
                    @pagination="paginate"
                    :server-items-length="totalAttendances"
                    :options.sync="options"
                    :loading="loading"
                    :footer-props="{
                        'items-per-page-options': listSize
                    }"
                >
                <template v-slot:[`item.type`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{attendanceType(item)}}</div>
                    </div>
                </template>
                <template v-slot:[`item.time_in`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.time_in|completeDate}}</div>
                    </div>
                </template>
                <template v-slot:[`item.time_out`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center" v-if="item.time_out">{{item.time_out|completeDate}}</div>
                    </div>
                </template>
                <template v-slot:[`item.is_claimed`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.is_claimed == 0 ? "No" : "Yes"}}</div>
                    </div>
                </template>
                <template v-slot:[`item.is_approved`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.is_approved == 0 ? "No" : "Yes"}}</div>
                    </div>
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <button class="btn btn-success btn-sm" title="Aprove" :disabled="disabledApproved(item)" @click="approve(item)">Approve</button>
                </template>
                </v-data-table>
            </div>
        </v-card>
    </div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
const today = new Date()
export default {
name: "Approve",
props: {
    sendToChild: Object,
},
mounted() {
    var data = {
        id: this.sendToChild.id
    }
    this.filteredAttendances(data)
    this.getFirstAndLast(data)
},
data() {
    return {
        filter: {},
        first_load: true,
        headers: [
            { text: 'Type', value: 'type' },
            { text: 'Time in', value: 'time_in' },
            { text: 'Time out', value: 'time_out' },
            { text: 'Paid', value: 'is_claimed' },
            { text: 'Approved', value: 'is_approved' },
            { text: 'Action', value: 'actions' },
            ],
        totalAttendances: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        month: this.month = today.toLocaleString('default', { month: 'long' }),
        year: '',
        years: [],
        first: '',
        last: '',
    }
},
methods: {
    ...mapActions({ 
        filterAttendances: "filterAttendances",
        getFirstAndLastRecord: "getFirstAndLastRecord"

    }),
    filteredAttendances(data) {
        this.filterAttendances(data)
        .then(response => {
            this.loading = false;
            this.totalAttendances = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 2000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.first_load = true
            var day = today.getUTCDate()
            if (this.month || this.year) {
                var month = this.months.indexOf(this.month)+1
                var year = this.year
            } else {
                var month = today.getUTCMonth() + 1;
                var year = today.getUTCFullYear()
            }
            var startOfMonth = new Date(year+"-"+month+"-"+day)
            
            this.filter = {...this.filter, startOfMonth: startOfMonth, id: this.sendToChild.id,  page: e.page, itemsPerPage: e.itemsPerPage}
            this.filterAttendances(this.filter)
            .then(response => {
                this.loading = false
            })
        }
    },
    getFirstAndLast(data) {
        this.getFirstAndLastRecord(data)
        .then(response => {
            if (response.data.first !== null) {
                this.first = parseInt(response.data.first.date)
                this.last = parseInt(response.data.last.date)
            }
            this.year = this.last
            for (this.first; this.first <= this.last; this.first++) {
                this.years.push(this.first)
            }
        })
    },
    changeMonth() {
        this.first_load = true
        var day = today.getUTCDate()
        if (this.month || this.year) {
            var month = this.months.indexOf(this.month)+1
            var year = this.year
        } else {
            var month = today.getUTCMonth() + 1;
            var year = today.getUTCFullYear()
        }
        var startOfMonth = new Date(year+"-"+month+"-"+day)
        var data = {
            startOfMonth: startOfMonth,
            id: this.sendToChild.id
        }
        this.filteredAttendances(data)
    },
    approve(data) {
        alert('bukas na')
    },
    attendanceType(data) {
        if (data.type == null) {
            if (data.time_in) {
                if (data.time_out == null) {
                    return "No time-out"
                } else {
                    return "In progress"
                }
            } else {
                return "Absent"
            }
        } else if (data.type == "Whole day") {
            return "Whole day"
        } else if (data.type == "Half day") {
            return "Half day"
        } else {
            return "Not Counted"
        }
    },
    disabledApproved(data) {
        if (data.type == null || data.time_out == null) {
            return true
        } else {
            return false
        }
    }
},
    computed: {
        ...mapGetters({
            employee: "employee",
            attendances: "attendances"
        }),
    }
}
</script>

<style>

</style>