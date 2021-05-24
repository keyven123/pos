<template>
<div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div id="carousel-example" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner row w-100 mx-auto" role="listbox">
                    <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 active">
                        <img src="images/milktea3.jpg" class="img-fluid d-block" style="width:100%; height: 200px" alt="img1">
                    </div>
                    <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3" style="width:25%; height: 200px" v-for="(category, index) in allCategories" :key="index">
                        <img :src="category.image ? category.image : 'images/20.jpg'" class="img-fluid d-block" :alt="category.name">
                    </div>
                    <!-- <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                        <img src="assets/img/photos/3.jpg" class="img-fluid mx-auto d-block" alt="img3">
                    </div>
                    <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                        <img src="assets/img/photos/4.jpg" class="img-fluid mx-auto d-block" alt="img4">
                    </div>
                    <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                        <img src="assets/img/photos/5.jpg" class="img-fluid mx-auto d-block" alt="img5">
                    </div>
                    <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                        <img src="assets/img/photos/6.jpg" class="img-fluid mx-auto d-block" alt="img6">
                    </div>
                    <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                        <img src="assets/img/photos/7.jpg" class="img-fluid mx-auto d-block" alt="img7">
                    </div>
                    <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                        <img src="assets/img/photos/red.jpg" class="img-fluid mx-auto d-block" alt="img8">
                    </div> -->
                </div>
                <a class="carousel-control-prev" href="#carousel-example" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-example" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <v-card>
                <v-card-title>
                    <h3>List of Category</h3>
                    <v-btn 
                    v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'category-create'))"
                    color="primary"
                    class="mb-2 ml-6"
                    fab
                    x-small
                    @click="showCreateForm"
                    >
                    <v-icon>
                        mdi-plus
                    </v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-text-field
                    v-model="search"
                    append-icon=""
                    label="Search Category"
                    single-line
                    hide-details
                    clearable
                    @click:clear="clearFilter"
                    ></v-text-field>
                    <v-btn
                        class="margin-top-16"
                        color="info"
                        fab
                        x-small
                        dark
                        @click="filterCategoryByName"
                        >
                        <v-icon>mdi-magnify</v-icon>
                    </v-btn>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="allCategories"
                    :search="search"
                    @pagination="paginate"
                    :server-items-length="totalCategories"
                    :options.sync="options"
                    :loading="loading"
                    :footer-props="{
                        'items-per-page-options': listSize
                    }"
                >
                <template v-slot:[`item.image`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">
                            <v-avatar>
                            <img
                                :src="item.image ? item.image : 'images/20.jpg'"
                            >
                            </v-avatar>
                        </div>
                    </div>
                </template>
                <template v-slot:[`item.created_at`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center">{{item.created_at|myDate}}</div>
                    </div>
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'category-edit'))"
                        class="btn btn-primary btn-sm" 
                        @click="selectCategory(item)"><i class="fas fa-edit"></i></button>
                    <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'category-delete'))"
                        class="btn btn-danger btn-sm" 
                        @click="deleteCategory(item)"><i class="fas fa-trash"></i></button>
                </template>
                </v-data-table>
            </v-card>
        </div>
    </div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
mounted() {
    this.getCategories()
    this.$store.dispatch("authenticate")
},
data() {
    return {
        category: '',
        search: '',
        filter: {},
        first_load: true,
        headers: [
            { text: 'Image', value: 'image' },
            {
                text: 'Category name',
                align: 'start',
                filterable: false,
                value: 'name',
            },
            { text: 'Created at', value: 'created_at' },
            { text: "Actions", value: "actions" }
            ],
        totalCategories: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getAllCategories: "getAllCategories" ,
        showCategory: "showCategory"

    }),
    getCategories() {
        this.getAllCategories()
        .then(response => {
            this.loading = false;
            this.totalCategories = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.getAllCategories(this.filter)
            .then(response => {
                this.loading = false
            })
        }
    },
    showCreateForm() {
        this.$emit('back', 'Create')
    },
    clearFilter(e) {
        console.log(e)
    },
    filterCategoryByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllCategories(this.filter)
        .then(response => {
            this.totalCategories = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectCategory(category) {
        this.showCategory(category)
        .then(() => {
            this.$emit("back", "Show");
        });
    },
    deleteCategory(category) {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.$store.dispatch("deleteCategory", category)
                .then(response => {
                    Swal.fire({
                    position: 'top-end',
                    icon: response.alert_type,
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                    })
                })
            }
        })
    }
},
    computed: {
        ...mapGetters({
            allCategories: "allCategories",
            userAuthentication: "userAuthentication"
        }),
    }
}
</script>

<style scoped>
/*
    code by Iatek LLC 2018 - CC 2.0 License - Attribution required
    code customized by Azmind.com
*/
@media (min-width: 768px) and (max-width: 991px) {
    /* Show 4th slide on md if col-md-4*/
    .carousel-inner .active.col-md-4.carousel-item + .carousel-item + .carousel-item + .carousel-item {
        position: absolute;
        top: 0;
        right: -33.3333%;  /*change this with javascript in the future*/
        z-index: -1;
        display: block;
        visibility: visible;
    }
}
@media (min-width: 576px) and (max-width: 768px) {
    /* Show 3rd slide on sm if col-sm-6*/
    .carousel-inner .active.col-sm-6.carousel-item + .carousel-item + .carousel-item {
        position: absolute;
        top: 0;
        right: -50%;  /*change this with javascript in the future*/
        z-index: -1;
        display: block;
        visibility: visible;
    }
}
@media (min-width: 576px) {
    .carousel-item {
        margin-right: 0;
    }
    /* show 2 items */
    .carousel-inner .active + .carousel-item {
        display: block;
    }
    .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left),
    .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item {
        transition: none;
    }
    .carousel-inner .carousel-item-next {
        position: relative;
        transform: translate3d(0, 0, 0);
    }
    /* left or forward direction */
    .active.carousel-item-left + .carousel-item-next.carousel-item-left,
    .carousel-item-next.carousel-item-left + .carousel-item,
    .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item {
        position: relative;
        transform: translate3d(-100%, 0, 0);
        visibility: visible;
    }
    /* farthest right hidden item must be also positioned for animations */
    .carousel-inner .carousel-item-prev.carousel-item-right {
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
        display: block;
        visibility: visible;
    }
    /* right or prev direction */
    .active.carousel-item-right + .carousel-item-prev.carousel-item-right,
    .carousel-item-prev.carousel-item-right + .carousel-item,
    .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item {
        position: relative;
        transform: translate3d(100%, 0, 0);
        visibility: visible;
        display: block;
        visibility: visible;
    }
}
/* MD */
@media (min-width: 768px) {
    /* show 3rd of 3 item slide */
    .carousel-inner .active + .carousel-item + .carousel-item {
        display: block;
    }
    .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item {
        transition: none;
    }
    .carousel-inner .carousel-item-next {
        position: relative;
        transform: translate3d(0, 0, 0);
    }
    /* left or forward direction */
    .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item {
        position: relative;
        transform: translate3d(-100%, 0, 0);
        visibility: visible;
    }
    /* right or prev direction */
    .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item {
        position: relative;
        transform: translate3d(100%, 0, 0);
        visibility: visible;
        display: block;
        visibility: visible;
    }
}
/* LG */
@media (min-width: 991px) {
    /* show 4th item */
    .carousel-inner .active + .carousel-item + .carousel-item + .carousel-item {
        display: block;
    }
    .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item + .carousel-item {
        transition: none;
    }
    /* Show 5th slide on lg if col-lg-3 */
    .carousel-inner .active.col-lg-3.carousel-item + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
        position: absolute;
        top: 0;
        right: -25%;  /*change this with javascript in the future*/
        z-index: -1;
        display: block;
        visibility: visible;
    }
    /* left or forward direction */
    .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
        position: relative;
        transform: translate3d(-100%, 0, 0);
        visibility: visible;
    }
    /* right or prev direction //t - previous slide direction last item animation fix */
    .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
        position: relative;
        transform: translate3d(100%, 0, 0);
        visibility: visible;
        display: block;
        visibility: visible;
    }
}
</style>