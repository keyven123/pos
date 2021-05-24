<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="updateProduct()">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-4">
                    <label class="col-form-label pt-0">Product Name</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('name')}" type="text" placeholder="Product name" v-model="name">
                        <label v-if="errors.hasOwnProperty('name')" class="text-danger">{{errors.name[0]}}</label>
                    </div>
                    <div class="col-4">
                    <label class="col-form-label pt-0">Description</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('description')}" type="text" placeholder="Description" v-model="description">
                        <label v-if="errors.hasOwnProperty('description')" class="text-danger">{{errors.description[0]}}</label>
                    </div>
                    <div class="col-4">
                    <label class="col-form-label pt-0">Barcode</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('barcode')}" type="text" placeholder="Barcode" v-model="barcode">
                        <label v-if="errors.hasOwnProperty('barcode')" class="text-danger">{{errors.barcode[0]}}</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <!-- <div class="col-4">
                        <label class="col-form-label pt-0">With Variation?</label>
                        <v-autocomplete
                            v-model="variation"
                            :items="variations"
                            dense
                            solo
                            clearable
                            item-text="status"
                            item-value="value"
                            placeholder="Select"
                        ></v-autocomplete>
                        <label v-if="errors.hasOwnProperty('variation')" class="text-danger">{{errors.variation[0]}}</label>
                    </div> -->
                    <div class="col-4">
                        <label class="col-form-label pt-0">Category</label>
                        <v-autocomplete
                            v-model="category_id"
                            :items="allCategories"
                            dense
                            solo
                            clearable
                            item-text="name"
                            item-value="id"
                            placeholder="Select Category"
                        ></v-autocomplete>
                        <label v-if="errors.hasOwnProperty('category_id')" class="text-danger">{{errors.category_id[0]}}</label>
                    </div>
                    <div class="col-4">
                        <label class="col-form-label pt-0">Status</label>
                        <v-autocomplete
                            v-model="is_available"
                            :items="statuses"
                            dense
                            solo
                            clearable
                            item-text="status"
                            item-value="value"
                            placeholder="Select status"
                        ></v-autocomplete>
                        <label v-if="errors.hasOwnProperty('is_available')" class="text-danger">{{errors.is_available[0]}}</label>
                    </div>
                </div>
            </div>
            <div class="form-group" v-if="variation == false">
                <div class="form-row">
                    <div class="col-4">
                    <label class="col-form-label pt-0">Price</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('price')}" step="any" type="number" placeholder="Price" v-model="price">
                        <label v-if="errors.hasOwnProperty('price')" class="text-danger">{{errors.price[0]}}</label>
                    </div>
                </div>
            </div>
            <div class="row" v-if="variation == true">
                <div class="col-md-5">
                    <form @submit.prevent="editmode ? updateVariant() : addVariant()">
                        <div class="form-group">
                            <label>Add your product variations here</label>
                            <div class="form-row">
                                <div class="col-12">
                                <label class="col-form-label pt-0">Variation name</label>
                                    <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('variation_name')}" type="text" placeholder="Variation name" v-model="variation_name">
                                    <label v-if="errors.hasOwnProperty('variation_name')" class="text-danger">{{errors.variation_name[0]}}</label>
                                </div>
                                <div class="col-12">
                                <label class="col-form-label pt-0">Price</label>
                                    <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('variation_price')}" step="any" type="number" placeholder="Price" v-model="variation_price">
                                    <label v-if="errors.hasOwnProperty('variation_price')" class="text-danger">{{errors.variation_price[0]}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="editmode" type="button" @click="cancelUpdate()" class="btn btn-sm btn-danger" style="color: #fff">Cancel</button>
                            <button v-if="!editmode" type="submit" class="btn btn-sm btn-primary" style="color: #fff">Add</button>
                            <button v-if="editmode" type="submit" class="btn btn-sm btn-primary" style="color: #fff">Update</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-7">
                    <v-simple-table>
                    <template v-slot:default>
                    <thead>
                        <tr>
                        <th class="text-left">Variation</th>
                        <th class="text-left">Price</th>
                        <th class="text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in allVariants" :key="index">
                        <td>{{ item.variation_name }}</td>
                        <td>{{ item.variation_price|currency }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" type="button" @click="selectVariation(item, index)" style="color: #fff"><i class="fas fa-pen"></i></button>
                            <button class="btn btn-danger btn-sm" type="button" @click="deleteVariation(item)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                        </tr>
                    </tbody>
                    </template>
                </v-simple-table>
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
    name: 'Show',
    mounted() {
        this.fillForm()
        this.getCategories()
        this.getVariants()
    },
    data() {
        return {
            editmode: false,
            id: null,
            variation_name: null,
            variation_price: null,
            variation_index: null,
            name: null,
            description: null,
            barcode: null,
            price: null,
            category_id: null,
            variation: 1,
            is_available: null,
            variants: [],
            status: 1,
            statuses: [
                {
                    value: 1,
                    status: 'Available',
                },
                {
                    value: 0,
                    status: 'Unavailable',
                }
            ],
            variations: [
                {
                    value: 1,
                    status: 'Yes',
                },
                {
                    value: 0,
                    status: 'No',
                }
            ],
            filter: [],
            categoryFilter: [],
            selected_designation: {},
            errors: {},
        }
    },
    methods: {
        ...mapActions({
            getAllCategories: "getAllCategories",
            getAllVariants: "getAllVariants",
            showVariant: "showVariant",
            createVariant: "createVariant"
        }),
        getCategories() {
            this.categoryFilter = {...this.categoryFilter, itemsPerPage: 1000}
            this.getAllCategories(this.categoryFilter)
        },
        updateProduct() {
            var data = {
                id: this.id,
                name: this.name,
                description: this.description,
                barcode: this.barcode,
                price: this.price,
                category_id: this.category_id,
                is_available: this.is_available,
                variation: this.variation
            }

            this.$store.dispatch('updateProduct', data)
            .then(response => {
                if (response.success == true) {
                    Swal.fire({
                    position: 'top-end',
                    icon: response.alert_type,
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                    })
                }
                this.$emit('back', 'List')
            }).catch(error => {
                if(error.response.status === 422) {
                    this.errors = error.response.data.errors
                    Swal.fire('Error', error.response.data.message , 'error')
                }
            })
        },
        async fillForm() {
            this.id = await this.product.id
            this.name = await this.product.name
            this.description = await this.product.description
            this.barcode = await this.product.barcode
            this.price = await this.product.price
            this.category_id = await this.product.category_id
            this.is_available = await this.product.is_available
            this.variation = await this.product.variation
            this.variants = await this.product.variants
        },
        async getVariants() {
            this.filter = {product_id: await this.product.id}
            this.getAllVariants(this.filter)
        },
        addVariant() {
            var data = {
                product_id: this.id,
                variation_name: this.variation_name,
                variation_price: this.variation_price
            }
            this.createVariant(data)
            .then(response => {
                this.getVariants()
                this.variation_name = null
                this.variation_price = null
                this.errors = {}
            }).catch(error => {
                if(error.response.status === 422) {
                    this.errors = error.response.data.errors
                    Swal.fire('Error', error.response.data.message , 'error')
                }
            })
        },
        selectVariation(variant, index) {
            this.showVariant(variant)
            this.editmode = true
            this.variation_index = index
            this.variation_name = variant.variation_name
            this.variation_price = variant.variation_price
        },
        cancelUpdate() {
            setInterval(() => this.editmode = false, 500)
            this.id = null
            this.variation_name = null
            this.variation_price = null
            this.errors = {}
        },
        updateVariant() {
            var data = {
                product_id: this.id,
                variation_name: this.variation_name,
                variation_price: this.variation_price
            }
            this.$store.dispatch("updateVariant", data)
            .then(response => {
                if(response.success) {
                    this.getVariants()
                    this.variants[this.variation_index].variation_name = this.variation_name
                    this.variants[this.variation_index].variation_price = this.variation_price
                    this.editmode = false
                    this.variation_name = null
                    this.variation_price = null
                }
            }).catch(error => {
                if(error.response.status === 422) {
                    this.errors = error.response.data.errors
                    Swal.fire('Error', error.response.data.message , 'error')
                }
            })
        },
        deleteVariation(data) {
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
                this.$store.dispatch("deleteVariant", data)
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
            product: "product",
            allCategories: "allCategories",
            allVariants: "allVariants"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>