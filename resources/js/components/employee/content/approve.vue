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
                    <v-spacer></v-spacer>
                    <div class="col-md-1 d-flex justify-content-center">
                        <div class="d-flex align-items-center"><button class="btn btn-sm btn-success" v-if="multiple" @click="approve()">Approved</button></div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center mr-3">
                        <div class="d-flex align-items-center"><button class="btn btn-sm btn-primary" v-if="!multiple" @click="multiple = true, multiple_data = []">Multiple select</button></div>
                        <div class="d-flex align-items-center"><button class="btn btn-sm btn-primary" v-if="multiple" @click="multiple = false">Single select</button></div>
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
                <template v-slot:[`item.radio`]="{ item }" v-if="multiple">
                    <div class="d-flex" v-if="!disabledApproved(item) && item.is_claimed == 0">
                        <div class="align-items-center">
                            <input type="checkbox" v-model="multiple_data" :value="item.id">
                        </div>
                    </div>
                </template>
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
                <template v-slot:[`item.actions`]="{ item }" v-if="!multiple">
                    <button class="btn btn-success btn-sm" title="Aprove" :disabled="item.is_claimed == 1" v-if="!disabledApproved(item)" @click="approve(item)">Approve</button>
                    <button class="btn btn-danger btn-sm" title="Reset" :disabled="item.is_claimed == 1" v-if="item.is_approved == 1" @click="resetApproval(item)">Reset</button>
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
        multiple: false,
        multiple_data: [],
        data: {},
        type: null,
        types: ["Whole day", "Half day", "Not counted"],
        filter: {},
        first_load: true,
        headers: [
            { text: '', value: 'radio' },
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
        getFirstAndLastRecord: "getFirstAndLastRecord",
        approveAttendance: "approveAttendance",
        revertAttendance: "revertAttendance"

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
        Swal.fire({
            title: 'Select attendance type',
            input: 'select',
            inputOptions: this.types,
            inputPlaceholder: 'Select type',
            showCancelButton: true,
            inputValidator: (value) => {
                var type = this.types[value]
                return new Promise((resolve) => {
                    resolve()
                    if(type) {
                        if(data) {
                            var config = {...this.data, data: data, type: type, multiple: false}
                            this.approveAttendance(config)
                                .then(response => {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: response.data.alert_type,
                                        title: response.data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    var data = {
                                        id: this.sendToChild.id
                                    }
                                    this.filteredAttendances(data)
                                })
                        } else {
                            var ids = this.multiple_data
                            var config = {...this.data, data: ids, type: type, multiple: true}
                            this.approveAttendance(config)
                                .then(response => {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: response.data.alert_type,
                                        title: response.data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    this.multiple = false
                                    var data = {
                                        id: this.sendToChild.id
                                    }
                                    this.filteredAttendances(data)
                                })
                        }
                    } else if (type == undefined ) {
                        Swal.fire('You need to select 1 type')
                    }
                })
            }
        })
    },
    resetApproval(data) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are going to revert your approval",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.revertAttendance(data)
                .then(response => {
                    Swal.fire({
                    position: 'top-end',
                    icon: response.data.alert_type,
                    title: response.data.message,
                    showConfirmButton: false,
                    timer: 1500
                    })
                    var data = {
                        id: this.sendToChild.id
                    }
                    this.filteredAttendances(data)
                })
            }
        })
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
        if (data.is_approved == 1) {
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