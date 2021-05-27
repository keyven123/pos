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
                                <h4>Time in:</h4>
                                <h4 v-if="attendanceNow && attendanceNow.hasOwnProperty('time_in')">{{attendanceNow.time_in|completeDate}}</h4>
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
                            <v-col md="5">
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
                            <v-col md="5">
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
            <div class="col-md-3">
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
                                <td>Keyven Rosal</td>
                            <td 
                            v-for="(table, index) in history"
                            :key="index"
                            >
                            <!-- :class="(table.content == null) ? 'grey' : ''" -->
                            <span v-if="table.is_present == true"><i class="fas fa-check" style="color:green"></i></span>
                            <span v-else-if="table.is_present == false"><i class="fas fa-times" style="color:red"></i></span>
                            <span v-else class="gray"></span>
                            </td>
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                </v-card>
            </div>
            <div class="col-md-12">
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
                    <template v-slot:[`item.time_in`]="{ item }">
                        <div class="d-flex">
                            <div class="align-items-center">{{item.time_in|completeDate}}</div>
                        </div>
                    </template>
                    <template v-slot:[`item.time_out`]="{ item }">
                        <div class="d-flex">
                            <div class="align-items-center">{{item.time_out|completeDate}}</div>
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
</template>
<script>
import axios from 'axios'
import { mapActions, mapGetters } from 'vuex'
const today = new Date()
export default {
    name: 'Show',
    mounted() {
        this.$store.dispatch("authenticate")
        this.thisAttendance()
        this.todayAttendance()
        this.numberOfDays()   
        this.getFirstAndLast()
        this.HistoryTable()
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
            getHistoryTable: "getHistoryTable"
        }),
        HistoryTable() {
            this.getHistoryTable()
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
        getFirstAndLast() {
            var data = {
                id: this.auth.id
            }
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
                            is_present: val[0].is_present
                        })
                    } else {
                        this.history.push({
                            day: i,
                            is_present: false
                        })
                    }
                }
            })
        },
        todayAttendance() {
            this.$store.dispatch("getTodayAttendance")
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
                axios.post('api/attendance')
                .then(response => {
                    Swal.fire({
                        icon: response.data.alert_type,
                        title: 'Your time-in for today is ' + response.data.data.time_in,
                        showConfirmButton: true,
                    })
                    this.todayAttendance()
                    this.thisAttendance()
                    this.getFirstAndLast()
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
                axios.put('api/attendance/1')
                .then(response => {
                    Swal.fire({
                        icon: response.data.alert_type,
                        title: 'Your time-out for today is ' + response.data.data.time_out,
                        showConfirmButton: true,
                    })
                    this.todayAttendance()
                })
              }
          })
        }
    },
    computed: {
        ...mapGetters({
            attendance: "attendance",
            userAuthentication: "userAuthentication",
            TableHistory: "TableHistory"
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
            if (this.attendanceNow && this.attendanceNow.hasOwnProperty('time_out') && this.attendanceNow.time_out) {
                return true
            } else {
                return false
            }
        },
    }

}
</script>

<style>

</style>