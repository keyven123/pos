<template>
    <div class="card">
        <div class="card-body ">
            <div class="row row-sm">
                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                    <div class="card  box-shadow-0 ">
                        <div class="card-header">
                            <h4 class="card-title mb-1">SYSTEM SUMMARY</h4>
                            <p class="mb-2"></p>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>License mode:</h5>
                                </div>
                                <div class="col-7">
                                    <h5 v-if="trial.value == 1"><b>Trial mode</b></h5>
                                    <h5 v-if="trial.value == 0"><b>Fully Licensed</b></h5>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>Trial until:</h5>
                                </div>
                                <div class="col-7">
                                    <h5><b>{{trial_end.value}}</b></h5>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>Application name:</h5>
                                </div>
                                <div class="col-7">
                                    <h5><b>{{app_name.value}}</b></h5>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>Start of day:</h5>
                                </div>
                                <div class="col-7">
                                    <h5><b>{{start_of_day.value}}</b></h5>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>End of day:</h5>
                                </div>
                                <div class="col-7">
                                    <h5><b>{{end_of_day.value}}</b></h5>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>Half day (hrs):</h5>
                                </div>
                                <div class="col-7">
                                    <h5><b>{{half_day.value}}</b></h5>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>Whole day (hrs):</h5>
                                </div>
                                <div class="col-7">
                                    <h5><b>{{whole_day.value}}</b></h5>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>Logo:</h5>
                                </div>
                                <div class="col-7">
                                    <img :src="logo.value" class="m-1" style="width: 35px; heigh:35px" >
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5">
                                    <h5>Banner:</h5>
                                </div>
                                <div class="col-7">
                                    <img :src="banner.value" class="m-1" style="width: 114px; heigh:114px" >
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xl-8 col-md-8 col-sm-8">
                    <div class="card  box-shadow-0 ">
                        <div class="card-header">
                            <h4 class="card-title mb-1">UPDATE SYSTEM SETTINGS</h4>
                            <p class="mb-2"></p>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row row-sm">
                                <div class="col-lg-7 col-md-7 mg-t-20 mg-lg-t-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Application name
                                            </div>
                                        </div>
                                        <input class="form-control" v-model="app_value" id="app_name" name="app_name" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 mg-t-20 mg-lg-t-0">
                                    <button class="btn btn-primary" @click.prevent="editSetting(app_name.id, app_value)">Update</button>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-4 col-md-4 mg-t-20 mg-lg-t-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Start of day
                                            </div>
                                        </div>
                                        <input class="form-control" v-model="start_value" id="start_of_day" name="start_of_day" type="time">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 mg-t-20 mg-lg-t-0">
                                    <button class="btn btn-primary" @click.prevent="editSetting(start_of_day.id, start_value)">Update</button>
                                </div>
                                <div class="col-lg-4 col-md-4 mg-t-20 mg-lg-t-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                End of day
                                            </div>
                                        </div>
                                        <input class="form-control" v-model="end_value" id="end_of_day" name="end_of_day" type="time">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 mg-t-20 mg-lg-t-0">
                                    <button class="btn btn-primary" @click.prevent="editSetting(end_of_day.id, end_value)">Update</button>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-4 col-md-4 mg-t-20 mg-lg-t-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Whole day
                                            </div>
                                        </div>
                                        <input class="form-control" v-model="whole_value" id="whole_day" name="whole_day" type="number" min="1" max="24">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 mg-t-20 mg-lg-t-0">
                                    <button class="btn btn-primary" @click.prevent="editSetting(whole_day.id, whole_value)">Update</button>
                                </div>
                                <div class="col-lg-4 col-md-4 mg-t-20 mg-lg-t-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Half day
                                            </div>
                                        </div>
                                        <input class="form-control" v-model="half_value" id="half_day" name="half_day" type="number" min="1" max="24">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 mg-t-20 mg-lg-t-0">
                                    <button class="btn btn-primary" @click.prevent="editSetting(half_day.id, half_value)">Update</button>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                                    <div class="card-body">
                                        <div class="main-content-label mg-b-5">
                                            Upload image for logo
                                        </div>
                                        <p class="mg-b-20">Best image ratio 1:1. png file extension only</p>
                                        <div class="row row-sm">
                                            <div class="col-sm-8 col-md-8 col-lg-8">
                                                <div class="input-group file-browser">
                                                    <input type="text" class="form-control browse-file" :placeholder="logo_image" readonly="">
                                                    <label class="input-group-btn">
                                                        <a><span class="btn btn-default">
                                                            Browse <input @change="changeLogo" type="file" style="display: none;">
                                                        </span></a>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <button class="btn btn-primary" @click.prevent="setImage(logo.id)">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                                    <div class="card-body">
                                        <div class="main-content-label mg-b-5">
                                            Upload image for banner
                                        </div>
                                        <p class="mg-b-20">Best image ratio 1:2-4. png file extension only</p>
                                        <div class="row row-sm">
                                            <div class="col-sm-8 col-md-8 col-lg-8">
                                                <div class="input-group file-browser">
                                                    <input type="text" class="form-control browse-file" :placeholder="banner_image" readonly="">
                                                    <label class="input-group-btn">
                                                        <a><span class="btn btn-default">
                                                            Browse <input @change="changeBanner" type="file" style="display: none;">
                                                        </span></a>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <button class="btn btn-primary" @click.prevent="setImage(banner.id)">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Default',
    mounted() {
        this.getSetting()
    },
    data() {
        return {
            app_name: [],
            trial: [],
            trial_end: [],
            start_of_day: [],
            end_of_day: [],
            half_day: [],
            whole_day: [],
            logo: [],
            banner: [],
            app_value: '',
            start_value: '',
            end_value: '',
            half_value: '',
            whole_value: '',
            logo_value: '',
            banner_value: '',
            logo_image: 'choose',
            banner_image: 'choose',
            attachment1: '',
            attachment2: ''
        }
    },
    methods: {
        getSetting() {
            this.$store.dispatch("getSetting")
            .then(response => {
                this.app_name = response.app_name,
                this.trial = response.trial,
                this.trial_end = response.trial_end,
                this.start_of_day = response.start_of_day,
                this.end_of_day = response.end_of_day,
                this.half_day = response.half_day,
                this.whole_day = response.whole_day,
                this.logo = response.logo,
                this.banner = response.banner
            })
        },

        editSetting(id, value) {
            var data = {
                id: id,
                value: value,
            }

            this.$store.dispatch("updateSetting", data)
            .then(response => {
                console.log(response)
                   if (response.success) {
                        Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: 'Settings Updated',
                        showConfirmButton: false,
                        timer: 1500
                        })
                        this.getSetting()

                    } else {
                        Swal.fire('Error', response.message , 'error')
                    }
                }).catch(error => {
                    if(error.response.status === 422) {
                        Swal.fire('Error', error.response.data.errors.value[0] , 'error')
                    }
                })
        },

        changeLogo(e) {
            this.attachment1 = e.target.files[0];
            this.logo_image =  e.target.files[0].name;
        },
        changeBanner(e) {
            this.attachment2 = e.target.files[0];
            this.banner_image = e.target.files[0].name;
        },
        setImage(id) {
            if (id == 8) {
                var attach = this.attachment1;
                var message = "Logo Updated";
            }
            if (id == 9) {
                var attach = this.attachment2;
                var message = "Banner Updated";
            }

            var data = new FormData();
                data.append('id',id)
                data.append('image', attach);
            this.$store.dispatch("uploadImage", data)
            .then(response => {
                if (response) {
                    Swal.fire({
                    position: 'top-end',
                    icon: response.alert_type,
                    title: message,
                    showConfirmButton: false,
                    timer: 1500
                    })
                    this.getSetting()
                } else {
                    Swal.fire('Error', 'Failed to upload image', 'error')
                }

            }).catch(error => {
                if(error.response.status === 422) {
                    Swal.fire('Error', error.response.data.message , 'error')
                }
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