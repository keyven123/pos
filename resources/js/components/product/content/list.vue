<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>List of Product</h3>
                <v-btn v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'product-create'))"
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
                label="Search product"
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
                    @click="filterProductByName"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="allProducts"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalProducts"
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
            <template v-slot:[`item.price`]="{ item }">
                <div class="d-flex">
                    <template  v-if="item.variation == true">
                        <div class="align-items-center h-100" v-for="data in item.variants" :key="data.id">
                            {{data.variation_name}}: {{data.variation_price|currency}}  ,
                        </div>
                    </template>
                    <div class="align-items-center h-100" v-if="item.variation == false">{{item.price|currency}}</div>
                </div>
            </template>
            <template v-slot:[`item.is_available`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center h-100" v-if="item.is_available == 1">Available</div>
                    <div class="align-items-center h-100" v-if="item.is_available == 0">Unavailable</div>
                </div>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'product-edit'))"
                    class="btn btn-primary btn-sm" 
                    @click="selectProduct(item)"><i class="fas fa-eye"></i></button>
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'product-delete'))"
                    class="btn btn-danger btn-sm" 
                    @click="deleteProduct(item)"><i class="fas fa-trash"></i></button>
            </template>
            </v-data-table>
        </v-card>
    </div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
mounted() {
    this.getProducts()
    this.$store.dispatch("authenticate")
    // this.product = this.$store.getters.getCurrentProduct;
},
data() {
    return {
        product: '',
        search: '',
        filter: {},
        first_load: true,
        headers: [
            { text: 'Image', value: 'image' },
            {
                text: 'Product name',
                align: 'start',
                filterable: false,
                value: 'name',
            },
            { text: 'Description', value: 'description' },
            { text: 'Barcode', value: 'barcode' },
            { text: 'Price (PHP)', value: 'price' },
            { text: 'Category', value: 'category.name' },
            { text: 'Status', value: 'is_available' },
            { text: "Actions", value: "actions" }
            ],
        totalProducts: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getAllProducts: "getAllProducts" ,
        showProduct: "showProduct"

    }),
    getProducts() {
        this.getAllProducts()
        .then(response => {
            this.loading = false;
            this.totalProducts = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.getAllProducts(this.filter)
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
    filterProductByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllProducts(this.filter)
        .then(response => {
            this.totalProducts = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectProduct(product) {
        this.showProduct(product)
        .then(() => {
            this.$emit("back", "Show");
        });
    },
    deleteProduct(product) {
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
                this.$store.dispatch("deleteProduct", product)
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
            allProducts: "allProducts",
            userAuthentication: "userAuthentication"
        }),
    }
}
</script>

<style>

</style>