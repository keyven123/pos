<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="addCategory()" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-6">
                    <v-file-input
                        @change="categoryImage"
                        accept="image/*"
                        label="Image file"
                        ref="image"
                    ></v-file-input>
                </div>
            </div>
            <div class="form-group">
                <div class="col-6">
                <label class="col-form-label pt-0">Category Name</label>
                    <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('name')}" type="text" placeholder="First name" v-model="name">
                    <label v-if="errors.hasOwnProperty('name')" class="text-danger">{{errors.name[0]}}</label>
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
        
    },
    data() {
        return {
            name: null,
            attachment: null,
            image: null,
            url: null,
            errors: {},
            search: '',
        }
    },
    methods: {
        ...mapActions({
            createCategory: "createCategory"
        }),
        categoryImage(e){
            this.attachment = e
				// let file = e.target.files[0];
				// if (file != undefined) {
                //     this.attachment = file;
                //     this.url = URL.createObjectURL(file);
                //     let reader = new FileReader();
                //         reader.onloadend = (file) => {
                //             this.form.profile_image = reader.result;
                //         }
                //         reader.readAsDataURL(file);
                // } else {
                //     this.attachment = null
                //     this.url = false
                // }
            },
        addCategory() {
            if (this.attachment) {
                this.image = this.attachment
            }
            let fd = new FormData()
			fd.append('name', this.name ? this.name : '');
			fd.append('image', this.image ? this.image : '');
            this.createCategory(fd)
            .then(response => {
                if (response.success) {
                    this.name =  null
                    Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                this.errors = {}
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