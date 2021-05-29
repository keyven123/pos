<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
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
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Ingredients',
    mounted() {
        this.dateRestriction()
    },
    data() {
        return {
            description: null,
            payroll_start: null,
            payroll_end: null,
            errors: {},
            date_restriction: '',
            min_date_restriction: null,
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
                } else {
                    Swal.fire('Error', response.message , 'error')
                }
            }).catch(error => {
                this.errors = error.response.data.errors
                Swal.fire('Error', error.response.data.message , 'error')
            })
        }
        
    },
    computed: {
        ...mapGetters({
            
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>