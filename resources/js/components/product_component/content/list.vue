<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>Alter Product Components</h3>
                <v-spacer></v-spacer>
                <v-text-field
                v-model="search"
                append-icon=""
                label="Search Ingredients"
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
                    @click="filterByName"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="allProductComponents"
                :single-expand="true"
                :expanded.sync="expanded"
                show-expand
                class="elevation-1"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalProductComponents"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:expanded-item="{ headers, item }">
            <td :colspan="headers.length">
                <v-data-table
                :headers="headers2"
                :items="item.product_components"
                :sort-by="['variant.variation_name']"
                :sort-desc="[true]"
                multi-sort
                class="elevation-1"
                >
                <template v-slot:[`item.quantity`]="{ item }">
                    <div class="d-flex">
                        <div class="align-items-center h-100">{{parseFloat(item.quantity)}}</div>
                    </div>
                </template>
                </v-data-table>
            </td>
            </template>
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
            <template v-slot:[`item.actions`]="{ item }">
                <button
                    class="btn btn-primary btn-sm" v-if="item.product_components.length == 0 && userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'ordering-edit'))"
                    @click="showCreateForm(item)"><i class="fas fa-plus"></i></button>
                    <button
                    class="btn btn-primary btn-sm" v-if="item.product_components.length > 0 && userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'ordering-edit'))"
                    @click="selectProductComponent(item)"><i class="fas fa-edit"></i></button>
                <!-- <button 
                    class="btn btn-danger btn-sm" 
                    @click="deleteProductComponent(item)"><i class="fas fa-trash"></i></button> -->
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
    this.getProductComponents()
    this.$store.dispatch("authenticate")
},
data() {
    return {
        expanded: [],
        search: '',
        filter: {},
        first_load: true,
        headers2: [
            {
                text: 'Ingredient Name',
                align: 'start',
                sortable: false,
                value: 'ingredient.name',
            },
            { text: 'Variant', value: 'variant.variation_name' },
            { text: 'Quantity', value: 'quantity' },
            { text: 'Unit', value: 'unit' },
        ],
        headers: [
            { text: '', value: 'data-table-expand' },
            { text: 'Image', value: 'image' },
            {
                text: 'Product name',
                align: 'start',
                filterable: false,
                value: 'name',
            },
            { text: 'Description', value: 'description' },
            { text: 'Barcode', value: 'barcode' },
            { text: "Actions", value: "actions" }
            ],
        totalProductComponents: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getAllProductComponents: "getAllProductComponents" ,
        showProductComponent: "showProductComponent"

    }),
    getProductComponents() {
        this.getAllProductComponents()
        .then(response => {
            this.loading = false;
            this.totalProductComponents = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.getAllProductComponents(this.filter)
            .then(response => {
                this.loading = false
            })
        }
    },
    showCreateForm(product) {
        this.$store.dispatch("showProductComponent", product)
        .then(() => {
            this.$emit("back", "Create");
        });
    },
    clearFilter(e) {
        console.log(e)
    },
    filterByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllProductComponents(this.filter)
        .then(response => {
            this.totalProductComponents = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectProductComponent(ingredient) {
        this.showProductComponent(ingredient)
        .then(() => {
            this.$emit("back", "Show");
        });
    },
    deleteProductComponent(ingredient) {
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
                this.$store.dispatch("deleteProductComponent", ingredient)
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
            allProductComponents: "allProductComponents",
            userAuthentication: "userAuthentication"
        }),
        arrange(data) {
            console.log(data)
        }
    }
}
</script>

<style>

</style>