<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="goBack()"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="addProduct()">
            <div class="form-group">
                <div class="col-6">
                    <v-file-input
                        @change="productImage"
                        accept="image/*"
                        label="Image file"
                        ref="image"
                    ></v-file-input>
                </div>
            </div>
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
                    <form @submit.prevent="editmode ? updateTempVariant() : addTempVariant()">
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
                        <tr v-for="(item, index) in temporary_variation" :key="index">
                        <td>{{ item.variation_name }}</td>
                        <td>{{ item.variation_price|currency }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" type="button" @click="selectVariation(item, index)" style="color: #fff"><i class="fas fa-pen"></i></button>
                            <button class="btn btn-danger btn-sm" type="button" @click="deleteVariation(index)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                        </tr>
                    </tbody>
                    </template>
                </v-simple-table>
                </div>
            </div>
            <button class="btn btn-primary" style="color: #fff" type="submit">Submit</button>
        </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Create',
    mounted() {
        this.load()
    },
    data() {
        return {
            editmode: false,
            variation_name: null,
            variation_price: null,
            variation_index: null,
            temporary_variation: [],
            headers: [
            { text: 'Variation', value: 'variation' },
            { text: "Price", value: "price" }
            ],
            category_id: null,
            name: null,
            description: null,
            barcode: null,
            price: null,
            image: null,
            variation: 1,
            is_available: 1,
            image: null,
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
            selected_designation: {},
            errors: {},
            search: '',
            filter: {}
        }
    },
    methods: {
        ...mapActions({
            createProduct: "createProduct",
            getAllCategories: "getAllCategories",
            createVariants: "createVariants"
        }),
        goBack() {
            this.$emit('back', 'List')
        },
        load() {
            this.filter = {...this.filter, itemsPerPage: 1000}
            this.getAllCategories(this.filter)
        },
        productImage(e){
            this.image = e
        },
        addProduct() {
            if (this.temporary_variation.length > 0 || this.variation == 0) {
                let fd = new FormData()
                fd.append('category_id', this.category_id ? this.category_id : '');
                fd.append('name', this.name ? this.name : '');
                fd.append('description', this.description ? this.description : '');
                fd.append('barcode', this.barcode ? this.barcode : '');
                fd.append('price', this.price ? this.price : '');
                fd.append('is_available', this.is_available ? this.is_available : '');
                fd.append('variation', this.variation);
                fd.append('image', this.image ? this.image : '');
                this.createProduct(fd)
                .then(response => {
                    if (response.success == true) {
                        Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                        })
                        this.category_id = null
                        this.name = null
                        this.description = null
                        this.image = null
                        this.barcode = null
                        this.price = null
                        this.errors = {}
                    }
                    if (response.data.id && response.data.variation == true) {
                        this.addVariation(response.data.id)
                    }
                        this.$emit('back', 'List')
                }).catch(error => {
                    if(error.response.status === 422) {
                        this.errors = error.response.data.errors
                        Swal.fire('Error', error.response.data.message , 'error')
                    }
                })
            } else {
                Swal.fire({
                icon: 'error',
                title: 'Please Add atleast 1 variant',
                showConfirmButton: true,
                })
            }
            
        },
        async addVariation(id) {
            var data = {
                id: id,
                variants: this.temporary_variation
            }
            this.createVariants(data)
        },
        addTempVariant() {
            const data = {
                variation_name: this.variation_name,
                variation_price: this.variation_price
            }
            this.temporary_variation.push(data)
            this.variation_name = null
            this.variation_price = null
        },
        selectVariation(data, index) {
            this.variation_index = index
            this.editmode = true
            this.variation_name = data.variation_name
            this.variation_price = data.variation_price
        },
        updateTempVariant() {
            this.temporary_variation[this.variation_index].variation_name = this.variation_name
            this.temporary_variation[this.variation_index].variation_price = this.variation_price
            this.variation_name = null
            this.variation_price = null
            this.editmode = false
        },
        deleteVariation(index) {
            this.temporary_variation.splice(index, 1)
        },
    },
    computed: {
        ...mapGetters({
            temp_variant: "temp_variant",
            allCategories: "allCategories",
            allTempVariants: "allTempVariants"
        })
    }
};
</script>

<style>
.btn-sm {
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 15px;
    padding-right: 15px;
    font-size: 12px;
}
</style>