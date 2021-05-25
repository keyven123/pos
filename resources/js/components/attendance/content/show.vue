<template>
  <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-md-12">
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
            </div>
            <div class="col-md-12">
                <v-row>
                    <v-col md="6">
                        <v-card>
                            <v-row justify="space-around">
                            <v-col md="5">
                                <h4>Time in:</h4>
                                <h4 v-if="attendanceNow && attendanceNow.hasOwnProperty('time_in')">{{attendanceNow.time_in|completeDate}}</h4>
                            </v-col>
                            <v-col md="5">
                                <h4>Time out</h4>
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
                                :disabled="!timeInExist"
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
        </div>
      </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Show',
    mounted() {
        this.thisAttendance()
        this.todayAttendance()
        this.numberOfDays()        
    },
    data() {
        return {
            number_of_days: null,
            attendanceNow: [],
            history: [],
        }
    },
    methods: {
        ...mapActions ({
            getMyAttendance: "getMyAttendance",
            getTodayAttendance: "getTodayAttendance"
        }),
        numberOfDays() {
            var date = new Date()
            var month = date.getMonth()+1
            var year = date.getFullYear()
            this.number_of_days = new Date(year, month, 0).getDate()
        },
        thisAttendance() {
            this.getMyAttendance()
            .then(response => {
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
                    console.log(this.history)
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
            attendance: "attendance"
        }),
        timeInExist() {
            if (this.attendanceNow && this.attendanceNow.hasOwnProperty('time_in')) {
                return true
            } else {
                return false
            }
        }
    }

}
</script>

<style>

</style>