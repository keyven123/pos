<template>
  <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <v-card-title>Attendance Check</v-card-title>
                <v-row>
                    <v-col md="6">
                        <v-card>
                            <v-row justify="space-around">
                            <v-col md="5">
                                <h4 class="ml-1">Time in:</h4>
                                <h4 class="ml-1" v-if="attendanceNow && attendanceNow.hasOwnProperty('time_in')">{{attendanceNow.time_in|completeDate}}</h4>
                            </v-col>
                            <v-col md="5">
                                <h4>Time out:</h4>
                                <h4 v-if="attendanceNow.time_out !== null && attendanceNow.hasOwnProperty('time_out')">{{attendanceNow.time_out|completeDate}}</h4>
                            </v-col>
                            </v-row>
                        </v-card>
                    </v-col>
                    <v-col md="6">
                        <v-card>
                            <v-row justify="space-around">
                            <v-col class="m-2" md="5">
                                <h4>Time in</h4>
                                <v-btn
                                :disabled="timeInExist"
                                depressed
                                color="primary"
                                @click.prevent="timeIn()"
                                >
                                Click here
                                </v-btn>
                            </v-col>
                            <v-col class="m-2" md="5">
                                <h4>Time out</h4>
                                <v-btn
                                :disabled="timeOutExist"
                                depressed
                                color="primary"
                                @click.prevent="timeOut()"
                                >
                                Click here
                                </v-btn>
                            </v-col>
                            </v-row>
                        </v-card>
                    </v-col>
                </v-row>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-5">
                        <v-card-title>History</v-card-title>
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
                    <div class="col-md-7">
                        <v-card-title>Legend</v-card-title>
                            <div>
                                <span> <i class="fas fa-check" style="color:green"></i> - Present</span>
                                <span> <i class="fas fa-slash" style="color:red"></i> - Half day </span>
                            </div>
                            <div>
                                <span> <i class="fas fa-times" style="color:red"></i> - Absent or no logs</span>
                                <span> <i class="far fa-times-circle" style="color:red"></i> - Not counted or Logged in for less than 4 hours</span>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <v-card>
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">
                                Employee
                            </th>
                            <th class="text-center" v-for="(table,index) in history" :key="index">
                                {{table.day}}
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{auth.first_name}} {{auth.last_name}}</td>
                            <td 
                            v-for="(table, index) in history"
                            :key="index"
                            >
                            <span><i :class="attendanceClass(table)" :style="attendanceStyle(table)"></i></span>
                            <!-- :class="(table.content == null) ? 'grey' : ''" -->
                            <!-- <span v-if="table.is_present == true"><i class="fas fa-check" style="color:green"></i></span>
                            <span v-else-if="table.is_present == false"><i class="fas fa-times" style="color:red"></i></span>
                            <span v-else class="gray"></span> -->
                            </td>
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                </v-card>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <v-card>
                            <v-card-title>
                                <h3>Attendance Summary</h3>
                            </v-card-title>
                            <v-simple-table>
                            <template v-slot:default>
                            <tbody>
                                <tr>
                                <td>Total Working days</td>
                                <td>{{summary.total_working_days}}</td>
                                </tr>
                                <tr>
                                <td>Whole day</td>
                                <td>{{summary.whole_day}}</td>
                                </tr>
                                <tr>
                                <td>Half day</td>
                                <td>{{summary.half_day}}</td>
                                </tr>
                                <tr>
                                <td>Not counted</td>
                                <td>{{summary.not_counted}}</td>
                                </tr>
                            </tbody>
                            </template>
                        </v-simple-table>
                        </v-card>
                    </div>
                    <div class="col-md-8">
                        <v-card>
                            <v-card-title>
                                <h3>Login Histories</h3>
                            </v-card-title>
                            <v-data-table
                                :headers="headers"
                                :items="TableHistory"
                                @pagination="paginate"
                                :server-items-length="totalHistory"
                                :options.sync="options"
                                :loading="loading"
                                :footer-props="{
                                    'items-per-page-options': listSize
                                }"
                            >
                            <template v-slot:[`item.type`]="{ item }">
                                <div class="d-flex">
                                    <div class="align-items-center" v-if="!item.type">Ongoing</div>
                                    <div class="align-items-center" v-if="item.type">{{item.type}}</div>
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
                                    <div class="align-items-center" v-if="!item.time_out"></div>
                                </div>
                            </template>
                            <template v-slot:[`item.is_approved`]="{ item }">
                                <div class="d-flex">
                                    <div class="align-items-center" v-if="item.is_approved == 0">No</div>
                                    <div class="align-items-center" v-if="item.is_approved == 1">Yes</div>
                                </div>
                            </template>
                            </v-data-table>
                        </v-card>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</template>
<script>
import axios from 'axios'
import { mapActions, mapGetters } from 'vuex'
const today = new Date()
export default {
    name: 'Show',
    mounted() {
        this.authenticate()
            .then(response => {
                this.auth = response.userAuthentication
                var data = {
                    id: this.auth.id
                }
                this.thisAttendance(data)
                this.numberOfDays()   
                this.getFirstAndLast(data)
                this.HistoryTable(data)
                this.todayAttendance(data)
                this.$store.dispatch("getAttendanceSummary", data)
            })
        
    },
    data() {
        return {
            totalHistory: 0,
            options: {},
            filter: {},
            loading: true,
            first_load: true,
            listSize: [10, 25, 50, 100],
            headers: [
            {
                text: 'Type',
                align: 'start',
                filterable: false,
                value: 'type',
            },
            { text: 'Time In', value: 'time_in' },
            { text: 'Time Out', value: 'time_out' },
            { text: 'Status', value: 'is_approved' },
            { text: 'Total hours', value: 'total_hour.hours' },
            ],
            auth: [],
            first: '',
            last: '',
            number_of_days: null,
            attendanceNow: [],
            history: [],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            month: this.month = today.toLocaleString('default', { month: 'long' }),
            year: '',
            years: [],
        }
    },
    methods: {
        ...mapActions ({
            authenticate: "authenticate",
            getMyAttendance: "getMyAttendance",
            getTodayAttendance: "getTodayAttendance",
            getFirstAndLastRecord: "getFirstAndLastRecord",
            getHistoryTable: "getHistoryTable",
            authenticate: "authenticate"
        }),
        HistoryTable(data) {
            this.getHistoryTable(data)
            .then(response => {
                this.loading = false;
                this.totalHistory = response.total;
                this.options = {...this.options, itemsPerPage: response.per_page}
                setTimeout(() => {
                    this.first_load = false
                }, 1000)
            })
        },
        paginate(e) {
            if(e.itemsLength !== 0 && !this.first_load) {
                this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
                this.getHistoryTable(this.filter)
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
                startOfMonth: startOfMonth
            }
            this.numberOfDays(startOfMonth)
            this.thisAttendance(data)
        },
        numberOfDays(data) {
            var date = data ? data : new Date()
            var month = date.getMonth()+1
            var year = date.getFullYear()
            this.number_of_days = new Date(year, month, 0).getDate()
        },
        thisAttendance(data) {
            this.getMyAttendance(data)
            .then(response => {
                this.history = []
                var i = 1;
                for (i; i <= this.number_of_days; i++) {
                    var val = response.filter(element => element.date == i)
                    if(val[0] !== undefined) {
                        this.history.push({
                            day: i,
                            is_present: val[0].is_present,
                            type: val[0].type
                        })
                    } else {
                        this.history.push({
                            day: i,
                            is_present: false,
                            type: null
                        })
                    }
                }
            })
        },
        todayAttendance(data) {
            this.getTodayAttendance(data)
            .then(response => {
                this.attendanceNow = response
            })
        },
        timeIn() {
            Swal.fire({
            title: 'Time in?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                var data = {
                    id: this.auth.id
                }
                this.$store.dispatch("createTimeIn", data)
                .then(response => {
                    if (response.success) {
                        Swal.fire({
                            icon: response.data.alert_type,
                            title: 'Your time-in for today is ' + response.data.time_in,
                            showConfirmButton: true,
                        })
                        this.todayAttendance(data)
                        this.thisAttendance(data)
                        this.getFirstAndLast(data)
                        this.HistoryTable(data)
                    } else {
                        Swal.fire({
                            icon: response.data.alert_type,
                            title: response.data.message,
                            showConfirmButton: true,
                        })
                    }
                })
              }
          })
        },
        timeOut() {
            Swal.fire({
            title: 'Time out?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                var data = {
                    id: this.auth.id
                }
                axios.put('api/attendance/1', data)
                .then(response => {
                    if (response.data.success == true) {
                        Swal.fire({
                            icon: response.data.alert_type,
                            title: 'Your time-out for today is ' + response.data.data.time_out,
                            showConfirmButton: true,
                        })
                        this.todayAttendance(data)
                        this.thisAttendance(data)
                        this.getFirstAndLast(data)
                        this.HistoryTable(data)
                    } else {
                        Swal.fire({
                            icon: response.data.alert_type,
                            title: response.data.message + " please click the time in first",
                            showConfirmButton: true,
                        })
                    }
                })
              }
          })
        },
        attendanceStyle(data) {
            if (data.type == null) {
                if (data.is_present) {
                    if (data.time_out == null) {
                        return "color:orange"
                    } else {
                        return "color:green"
                    }
                } else {
                    return "color:red"
                }
            } else if (data.type == "Whole day") {
                return "color:green"
            } else if (data.type == "Half day") {
                return "color:orange"
            } else {
                return "color:red"
            }
        },
        attendanceClass(data) {
            if (data.type == null) {
                if (data.is_present) {
                    if (data.time_in && data.time_out) {
                        return "fas fa-check"
                    } else {
                        return "fas fa-exclamation"
                    }
                } else {
                    return "fas fa-times"
                }
            } else if (data.type == "Whole day") {
                return "fas fa-check"
            } else if (data.type == "Half day") {
                return "fas fa-slash"
            } else {
                return "far fa-times-circle"
            }
        }
    },
    computed: {
        ...mapGetters({
            attendance: "attendance",
            userAuthentication: "userAuthentication",
            TableHistory: "TableHistory",
            summary: "summary"
        }),
        timeInExist() {
            var hour = today.getHours()
            if (this.attendanceNow && this.attendanceNow.hasOwnProperty('time_in') ) {
                return true
            } else {
                if(hour >= 8) {
                    return false
                } else {
                    return true
                }
            }
        },
        timeOutExist() {
            var hour = today.getHours()
            if (this.attendanceNow && this.attendanceNow.hasOwnProperty('time_out') && this.attendanceNow.time_out) {
                return true
            } else {
                if(hour >= 8 && this.attendanceNow.time_in !== null && this.attendanceNow.hasOwnProperty('time_in')) {
                    return false
                } else {
                    return true
                }
            }
        }
    }

}
</script>

<style>

</style>