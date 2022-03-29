<template>
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" :src="profile.image ? profile.image : '/images/profile/profile6.png'"><a class="fas fa-camera profile-edit" href="JavaScript:void(0);" data-toggle="modal" data-target="#showImages"></a>
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{profile.first_name}} {{profile.last_name}}</h5>
                                    <p class="main-profile-name-text">{{role}}</p>
                                </div>
                            </div>
                            <h6>Email</h6>
                            <div class="main-profile-bio">
                                {{profile.email}}
                            </div>
                            <h6>Username</h6>
                            <div class="main-profile-bio">
                                {{profile.username}}
                            </div>
                            <h6>Contact</h6>
                            <div class="main-profile-bio">
                                {{profile.contact}}
                            </div>
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                            <li class="active">
                                <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">Edit Information</span> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                        <div class="tab-pane active" id="home">
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
                            <button class="btn btn-primary" type="submit" style="color: #fff">Update</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="showImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose Profile Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="#"><img v-for="(image, index) in images" :key="index" :src="image.image" class="m-1" style="width: 114px; heigh:114px" @click="changeImage(image.image)"></a>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#profileImage">Upload photo</button>
            </div>
            </div>
        </div>
        </div>

        <div class="modal fade" id="profileImage" tabindex="-1" role="dialog" aria-labelledby="profileImageLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-body">
                <form @submit.prevent="UploadImage()">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="img">Change User Profile</label>
                        <div class="col-sm-12">
                            <input @change="userImage" accept="image/*" type="file" name="image" ref="image" id="image">
                        </div>
                    </div>
                    <div id="preview">
                        <img v-if="url" :src="url" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary text-white">Save changes</button>
                    </div>
                </form>
            </div>
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
        this.getProfileInfo(),
        this.attachment = null
    },
    data() {
        return {
            attachment: null,
            url: '',
            dialog: false,
            user: [],
            role: null,
            change_password: false,
            id: null,
            first_name: null,
            last_name: null,
            designation_id: null,
            email: null,
            contact: null,
            username: null,
            image: null,
            password: null,
            confirm_password: null,
            profile_image: null,
            errors: {},
            search: '',
            images: [
                 {image: '/images/profile/avatar-s-1.png' },
                 {image: '/images/profile/avatar-s-2.png' },
                 {image: '/images/profile/avatar-s-3.png' },
                 {image: '/images/profile/avatar-s-4.png' },
                 {image: '/images/profile/avatar-s-5.png' },
                 {image: '/images/profile/avatar-s-6.png' },
                 {image: '/images/profile/avatar-s-7.png' },
                 {image: '/images/profile/avatar-s-8.png' },
                 {image: '/images/profile/avatar-s-9.png' },
                 {image: '/images/profile/avatar-s-10.png' },
                 {image: '/images/profile/avatar-s-11.png' },
                 {image: '/images/profile/avatar-s-12.png' },
                 {image: '/images/profile/avatar-s-13.png' },
                 {image: '/images/profile/avatar-s-14.png' },
                 {image: '/images/profile/avatar-s-15.png' },
                 {image: '/images/profile/avatar-s-16.png' },
                 {image: '/images/profile/avatar-s-17.png' },
                 {image: '/images/profile/avatar-s-18.png' },
                 {image: '/images/profile/avatar-s-19.png' },
                 {image: '/images/profile/avatar-s-20.png' },
                 {image: '/images/profile/avatar-s-22.png' },
                 {image: '/images/profile/avatar-s-23.png' },
                 {image: '/images/profile/avatar-s-24.png' },
                 {image: '/images/profile/avatar-s-25.png' },
                 {image: '/images/profile/profile1.jpg' },
                 {image: '/images/profile/profile2.png' },
                 {image: '/images/profile/profile3.png' },
                 {image: '/images/profile/profile4.jpg' },
                 {image: '/images/profile/profile5.jpg' },
                 {image: '/images/profile/profile6.png' },
            ]
        }
    },
    methods: {
        getProfileInfo() {
            this.$store.dispatch("getProfile")
            .then(response => {
                this.role = response.designation.name
                this.id = response.id
                this.first_name = response.first_name
                this.last_name = response.last_name
                this.designation_id = response.designation_id
                this.email = response.email
                this.username = response.username
                this.image = response.image
                this.contact = response.contact
            })
        },
        changeImage(image) {
            $('#showImages').modal('hide');
            Swal.fire({
            title: 'Change Profile?',
            imageUrl: image,
            imageWidth: 150,
            imageHeight: 150,
            imageAlt: 'Custom image',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.image = image
                    var data = {
                        id: this.id,
                        image: this.image,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        designation_id: this.designation_id,
                        username: this.username,
                        email: this.email,
                        contact: this.contact
                    }
                    this.$store.dispatch("updateProfile", data)
                    .then(response => {
                        Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: 'Updated Profile',
                        showConfirmButton: false,
                        timer: 1500
                        })
                        this.getProfileInfo()
                    })
                } else {
                    $('#showImages').modal('show');
                }
            })
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
                    username: this.username,
                    password: this.password
                }
                
                Swal.fire({
                    title: 'Are you sure?',
                    // text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch("updateProfile", data)
                        .then(response => {
                            if (response.success) {
                                Swal.fire({
                                position: 'top-end',
                                icon: response.alert_type,
                                title: 'Updated Profile',
                                showConfirmButton: false,
                                timer: 1500
                                })
                            }
                            this.getProfileInfo()
                            this.errors = {}
                            this.change_password = false
                        }).catch(error => {
                            this.errors = error.response.data.errors
                            Swal.fire('Error', error.response.data.message , 'error')
                        })
                    }
                })
            } else {
                this.errors = {}
                this.errors.password = ["Mismatch Password"]
                this.errors.confirm_password = "Mismatch Password"
                Swal.fire('Error', 'Password mismatch' , 'error')
            }
        },

        UploadImage(){
                let fd = new FormData();
                fd.append('profile_image', this.attachment);
                fd.append('id',this.id)
                this.$store.dispatch("uploadProfile", fd)
                .then(response => {
                    if(response.success){
                        $('#profileImage').modal('hide');
                        $('.modal-backdrop').remove();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Profile Image updated Successfully',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        this.getProfileInfo()
                    } else {
                        $('#profileImage').modal('hide');
                        $('.modal-backdrop').remove();
                        Swal.fire('Error', response.message , 'error')
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors
                    Swal.fire('Error', error.response.data.message , 'error')
                })
            },
            userImage(e){
                let file = e.target.files[0];
                this.attachment = file;
                this.url = URL.createObjectURL(file);
                let reader = new FileReader();
                    reader.onloadend = (file) => {
                        this.profile_image = reader.result;
                    }
                    reader.readAsDataURL(file);
            },
        
    },
    computed: {
        ...mapGetters({
            profile: "profile"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>