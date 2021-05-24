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
                        <th class="text-center" v-for="(table,index) in tables" :key="index">
                            {{table.no}}
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Keyven Rosal</td>
                        <td 
                        v-for="(table, index) in tables"
                        :key="index"
                        :class="(table.content == null) ? 'grey' : ''"
                        >
                        <span v-if="table.content == 1"><i class="fas fa-check" style="color:green"></i></span>
                        <span v-if="table.content == 0"><i class="fas fa-times" style="color:red"></i></span>
                        <span v-if="table.content == 2" class="gray"></span>
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
        this.getMyAttendance()
        this.todayAttendance()
    },
    data() {
        return {
            attendanceNow: [],
            tables: [
                {
                    no: 1,
                    name: 'Mark',
                    content: null
                },
                {
                    no: 2,
                    name: 'Otto',
                    content: 1
                },
                {
                    no: 3,
                    name: 'Test',
                    content: 1
                },
                {
                    no: 4,
                    name: '',
                    content: 0
                },
                {
                    no: 5,
                    name: '',
                    content: 0
                },
                {
                    no: 6,
                    name: '',
                    content: 0
                },
                {
                    no: 7,
                    name: '',
                    content: 0
                },
                {
                    no: 8,
                    name: '',
                    content: 0
                },
                {
                    no: 9,
                    name: '',
                    content: 0
                },
                {
                    no: 10,
                    name: '',
                    content: 0
                },
                {
                    no: 11,
                    name: '',
                    content: 0
                },
                {
                    no: 12,
                    name: '',
                    content: 0
                },
                {
                    no: 13,
                    name: '',
                    content: 0
                },
                {
                    no: 14,
                    name: '',
                    content: 0
                },
                {
                    no: 15,
                    name: '',
                    content: 0
                },
                {
                    no: 16,
                    name: '',
                    content: 0
                },
                {
                    no: 17,
                    name: '',
                    content: 0
                },
                {
                    no: 18,
                    name: '',
                    content: 0
                },
                {
                    no: 19,
                    name: '',
                    content: 0
                },
                {
                    no: 20,
                    name: '',
                    content: 0
                },
                {
                    no: 21,
                    name: '',
                    content: 0
                },
                {
                    no: 22,
                    name: '',
                    content: 0
                },
                {
                    no: 23,
                    name: '',
                    content: 0
                },
                {
                    no: 24,
                    name: '',
                    content: 0
                },
                {
                    no: 25,
                    name: '',
                    content: 0
                },
                {
                    no: 26,
                    name: '',
                    content: 0
                },
                {
                    no: 27,
                    name: '',
                    content: 0
                },
                {
                    no: 28,
                    name: '',
                    content: 0
                },
                {
                    no: 29,
                    name: '',
                    content: 0
                },
                {
                    no: 30,
                    name: '',
                    content: 0
                },
                {
                    no: 31,
                    name: '',
                    content: 0
                },
                
            ],
        }
    },
    methods: {
        ...mapActions ({
            getMyAttendance: "getMyAttendance",
            getTodayAttendance: "getTodayAttendance"
        }),
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