<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="updateUser()">
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
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+63</span>
                            </div>
                            <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('contact')}" type="text" placeholder="Contact Number" v-model="contact">
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
                <div class="col-4">
                <label class="col-form-label pt-0">Date hired</label>
                    <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('date_hire')}" type="date" placeholder="Date hired" v-model="date_hire">
                    <label v-if="errors.hasOwnProperty('date_hire')" class="text-danger">{{errors.date_hire[0]}}</label>
                </div>
            </div>
            <div class="mb-3">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" v-model="change_password">
                    <label class="custom-control-label" for="customSwitch1">Do you want to reset the password? <b>{{(change_password) ? 'Yes' : 'No'}}</b></label>
                </div>
            </div>
            <template v-if="change_password">
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
            </template>
            <button class="btn btn-primary" type="submit" style="color: #fff">Submit</button>
        </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Show',
    mounted() {
        this.getDesignations()
        this.fillForm()
    },
    data() {
        return {
            change_password: false,
            id: null,
            first_name: null,
            last_name: null,
            designation_id: null,
            email: null,
            contact: null,
            date_hire: null,
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
        }),
        getDesignations() {
            this.getAllDesignations()
        },
        async fillForm() {
            this.id = await this.user.id
            this.first_name = await this.user.first_name
            this.last_name = await this.user.last_name
            this.designation_id = await this.user.designation_id
            this.email = await this.user.email
            this.username = await this.user.username
            this.contact = await this.user.contact
            this.date_hire = await this.user.date_hire
        },
        async updateUser() {
            if (this.password == '') {
                this.password = null
            }
            if (this.confirm_password == '') {
                this.confirm_password = null
            }
            if (this.password == this.confirm_password) {
                var data = {
                    id: this.id,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    designation_id: this.designation_id,
                    email: this.email,
                    contact: this.contact,
                    date_hire: this.date_hire,
                    username: this.username,
                    password: this.password
                }
                this.$store.dispatch("updateUser", data)
                .then(response => {
                    if (response.success) {
                        Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: response.message + ' username: ' + response.data.username,
                        showConfirmButton: false,
                        timer: 1500
                        })
                    }
                    this.change_password = false
                    this.errors = {}
                    this.$emit('back', 'List')
                }).catch(error => {
                    this.errors = error.response.data.errors
                    Swal.fire('Error', error.response.data.message , 'error')
                })
            } else {
                this.errors = {}
                this.errors.password = ["Mismatch Password"]
                this.errors.confirm_password = "Mismatch Password"
                Swal.fire('Error', 'Password mismatch' , 'error')
            }
            // console.log(data)
        }
        // addUser() {
        //     if(this.password == this.confirm_password) {
        //         const data = {
        //             first_name: this.first_name,
        //             last_name: this.last_name,
        //             designation_id: this.designation_id,
        //             email: this.email,
        //             username: this.username,
        //             password: this.password,
        //         }
        //         this.createUser(data)
        //         .then(response => {
        //             if (response.success) {
        //                 this.$emit('back', 'List')
        //                 this.first_name =  null
        //                 this.last_name =  null
        //                 this.designation_id =  null
        //                 this.email =  null
        //                 this.username =  null
        //                 this.password =  null
        //                 this.errors = {}
        //             }
        //         }).catch(error => {
        //             this.errors = error.response.data.errors
        //             Swal.fire('Error', error.response.data.message , 'error')
        //         })
        //     } else {
        //         this.errors = {}
        //         this.errors.confirm_password = "Mismatch Password"
        //         Swal.fire('Error', 'Password mismatch' , 'error')
        //     }
        // }
        
    },
    computed: {
        ...mapGetters({
            user: "user",
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