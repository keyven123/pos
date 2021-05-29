<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="addUser()">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-4">
                    <label class="col-form-label pt-0">First Name</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('first_name')}" type="text" placeholder="First name" v-model="first_name">
                        <label v-if="errors.hasOwnProperty('first_name')" class="text-danger">{{errors.first_name[0]}}</label>
                    </div>
                    <div class="col-4">
                    <label class="col-form-label pt-0">Last Name</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('last_name')}" type="text" placeholder="Last Name" v-model="last_name">
                        <label v-if="errors.hasOwnProperty('last_name')" class="text-danger">{{errors.last_name[0]}}</label>
                    </div>
                    <div class="col-4">
                        <label class="col-form-label pt-0">Contact Number</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">+63</span>
                            </div>
                            <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('contact')}" type="number" minlength="10" maxlength="10" placeholder="Contact Number" v-model="contact">
                        </div>
                        <label v-if="errors.hasOwnProperty('contact')" class="text-danger">{{errors.contact[0]}}</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-4">
                    <label class="col-form-label pt-0">Username</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('username')}" type="text" placeholder="Username" v-model="username">
                        <label v-if="errors.hasOwnProperty('username')" class="text-danger">{{errors.username[0]}}</label>
                    </div>
                    <div class="col-4">
                    <label class="col-form-label pt-0">Email Address</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('email')}" type="email" placeholder="Email Address" v-model="email">
                        <label v-if="errors.hasOwnProperty('email')" class="text-danger">{{errors.email[0]}}</label>
                    </div>
                    <div class="col-4">
                        <label class="col-form-label pt-0">Designation</label>
                        <v-autocomplete
                            v-model="designation_id"
                            :items="allDesignations"
                            dense
                            solo
                            clearable
                            item-text="name"
                            item-value="id"
                            placeholder="Select User Designation"
                        ></v-autocomplete>
                        <label v-if="errors.hasOwnProperty('designation_id')" class="text-danger">{{errors.designation_id[0]}}</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                    <label class="col-form-label pt-0">Rate</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('rate')}" type="number" min="0" step="any" placeholder="Rate" v-model="rate">
                        <label v-if="errors.hasOwnProperty('rate')" class="text-danger">{{errors.rate[0]}}</label>
                    </div>
                    <div class="col-4">
                    <label class="col-form-label pt-0">Date hired</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('date_hire')}" type="date" placeholder="Date hired" v-model="date_hire">
                        <label v-if="errors.hasOwnProperty('date_hire')" class="text-danger">{{errors.date_hire[0]}}</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                    <label class="col-form-label pt-0">Password</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('password')}" minlength="8" type="password" placeholder="Password" v-model="password">
                        <label v-if="errors.hasOwnProperty('password')" class="text-danger">{{errors.password[0]}}</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                    <label class="col-form-label pt-0">Confirm Password</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('confirm_password')}" minlength="8" type="password" placeholder="Confirm Password" v-model="confirm_password">
                        <label v-if="errors.hasOwnProperty('confirm_password')" class="text-danger">{{errors.confirm_password}}</label>
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
    name: 'Create',
    mounted() {
        this.getDesignations()
    },
    data() {
        return {
            first_name: null,
            last_name: null,
            designation_id: null,
            email: null,
            contact: null,
            date_hire: null,
            rate: null,
            username: null,
            password: null,
            confirm_password: null,
            errors: {},
            search: '',
        }
    },
    methods: {
        ...mapActions({
            getAllDesignations: "getAllDesignations",
            createUser: "createUser"
        }),
        getDesignations() {
            this.getAllDesignations()
        },
        addUser() {
            if(this.password == this.confirm_password) {
                const data = {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    designation_id: this.designation_id,
                    email: this.email,
                    contact: this.contact,
                    date_hire: this.date_hire,
                    rate: this.rate,
                    username: this.username,
                    password: this.password,
                }
                this.createUser(data)
                .then(response => {
                    if (response.success) {
                        this.$emit('back', 'List')
                        this.first_name =  null
                        this.last_name =  null
                        this.designation_id =  null
                        this.email =  null
                        this.contact =  null
                        this.date_hire =  null
                        this.rate =  null
                        this.username =  null
                        this.password =  null
                        this.errors = {}
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors
                    Swal.fire('Error', error.response.data.message , 'error')
                })
            } else {
                this.errors = {}
                this.errors.confirm_password = "Mismatch Password"
                Swal.fire('Error', 'Password mismatch' , 'error')
            }
        }
        
    },
    computed: {
        ...mapGetters({
            allDesignations: "allDesignations"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>