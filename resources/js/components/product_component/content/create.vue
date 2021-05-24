<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <h2>Add Product Components to {{product_component.name}}</h2>
            <div class="row">
                <div class="col-md-4">
                    <v-card class="p-2">
                        <form @submit.prevent="editmode ? updateProductComponent() :addProductComponent()">
                        <div class="card-title">Create Product Component</div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" v-if="product_component.variants.length > 0">
                                    <label class="col-form-label pt-0">Variation name</label>
                                    <v-autocomplete
                                    :class="{'is-invalid border border-danger': errors.hasOwnProperty('name')}"
                                    v-model="variant_id"
                                    dense
                                    filled
                                    solo
                                    clearable
                                    :items="product_component.variants"
                                    item-text="variation_name"
                                    item-value="id"
                                    placeholder="Select variation"
                                    @change="changeVariation()"
                                    ></v-autocomplete>
                                    <label v-if="errors.hasOwnProperty('ingredient_id')" class="text-danger">{{errors.ingredient_id[0]}}</label>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Ingredient name</label>
                                    <v-autocomplete
                                    :class="{'is-invalid border border-danger': errors.hasOwnProperty('name')}"
                                    v-model="ingredient_id"
                                    dense
                                    filled
                                    solo
                                    clearable
                                    :items="allIngredients"
                                    item-text="name"
                                    item-value="id"
                                    placeholder="Select Ingredient"
                                    ></v-autocomplete>
                                    <label v-if="errors.hasOwnProperty('ingredient_id')" class="text-danger">{{errors.ingredient_id[0]}}</label>
                                </div>
                                <div class="form-group">
                                <label class="col-form-label pt-0">Quantity</label>
                                    <div class="input-group">
                                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('quantity')}" min="0.001" step="any" type="number" placeholder="Quantity" v-model="quantity">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{getUnit}}</span>
                                        </div>
                                    </div>
                                    <label v-if="errors.hasOwnProperty('quantity')" class="text-danger">{{errors.quantity[0]}}</label>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button v-if="!editmode" class="btn btn-primary" type="submit" style="color: #fff">Add</button>
                                    <button v-if="editmode" @click="cancelUpdate()" class="btn btn-danger" type="button" style="color: #fff">Cancel</button>
                                    <button v-if="editmode" class="btn btn-primary" type="submit" style="color: #fff">Update</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </v-card>
                </div>
                <div class="col-md-8">
                    <v-card class="p-2">
                        <div class="card-title">Product Components</div>
                        <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">Name</th>
                            <th class="text-left">Variant</th>
                            <th class="text-left">Quantity</th>
                            <th class="text-left"> Unit</th>
                            <th class="text-left"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                            v-for="(item, index) in components"
                            :key="(index)"
                            >
                            <td>{{ item.name }}</td>
                            <td>{{ item.variation_name }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ item.unit }}</td>
                            <td>
                                <button 
                                    class="btn btn-primary btn-sm" @click="editComponent(item, index)"><i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    class="btn btn-danger btn-sm" @click="deleteComponent(index)"><i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                    <div class="d-flex justify-content-end">
                        <button :disabled="components.length == 0" @click="submitProductComponent()" class="btn btn-primary" type="submit" style="color: #fff">Submit</button>
                    </div>
                    </v-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Create',
    mounted() {
        this.getIngredients()
    }, 
    data() {
        return {
            index: null,
            product_id: '',
            editmode: false,
            name: null,
            ingredient_id: null,
            variation_name: null,
            variant_id: null,
            quantity: null,
            unit: null,
            errors: {},
            search: '',
            components: [],
            filter: {},
        }
    },
    methods: {
        ...mapActions({
            createCategory: "createCategory",
            getAllIngredients: "getAllIngredients"
        }),
        getIngredients() {
            this.filter = {...this.filter, itemsPerPage: 1000}
            this.getAllIngredients(this.filter)
        },
        changeVariation() {
            if (this.variant_id) {
                var variation = this.product_component.variants.filter(variant => {
                    return variant.id == this.variant_id
                })
                this.variation_name = variation[0].variation_name
            }
        },
        addProductComponent() {
            this.components.push({
                variation_name: this.variation_name,
                variant_id: this.variant_id,
                product_id: this.product_component.id,
                name: this.name,
                ingredient_id: this.ingredient_id,
                quantity: this.quantity,
                unit: this.unit,
            })
            this.variation_name = null
            this.variant_id = null
            this.ingredient_id = null
            this.name = null
            this.quantity = null
            this.unit = null
        },

        submitProductComponent() {
            Swal.fire({
            title: 'Are you sure?',
            text: "Submit Product Components",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.$store.dispatch("createProductComponent", this.components)
                .then(response => {
                    if (response.success) {
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
            }
        })
        },

        editComponent(component, index) {
            this.editmode = true 
            this.index = index
            this.name = component.name
            this.variant_id = component.variant_id
            this.variation_name = component.variation_name
            this.ingredient_id = component.ingredient_id
            this.quantity = component.quantity
            this.unit = component.unit
        },
        updateProductComponent() {
            this.components[this.index].name = this.name
            this.components[this.index].variation_name = this.variation_name
            this.components[this.index].variant_id = this.variant_id
            this.components[this.index].ingredient_id = this.ingredient_id
            this.components[this.index].quantity = this.quantity
            this.components[this.index].unit = this.unit
            this.editmode = false
            this.ingredient_id = null
            this.name = null
            this.variant_id = null
            this.variation_name = null
            this.quantity = null
            this.unit = null
        },
        cancelUpdate() {
            this.editmode = false
            this.ingredient_id = null
            this.name = null
            this.variant_id = null
            this.variation_name = null
            this.quantity = null
            this.unit = null
        },
        deleteComponent(index) {
            this.components.splice(index, 1)
        }
        
    },
    computed: {
        ...mapGetters({
            product_component: "product_component",
            allIngredients: "allIngredients"
        }),
        getUnit() {
            if (this.ingredient_id) {
                var component = this.allIngredients.filter(ingredient => {
                    return ingredient.id == this.ingredient_id
                })
                this.name = component[0].name
                this.unit = component[0].unit
                return component[0].unit
            }
        },
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>