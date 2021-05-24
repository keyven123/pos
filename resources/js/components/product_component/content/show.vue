<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <h2>Edit Product Components to {{product_component.name}}</h2>
            <div class="row">
                <div class="col-md-4">
                    <v-card class="p-2">
                        <form @submit.prevent="editmode ? updateProductComponent() :addProductComponent()">
                        <div class="card-title">Edit Product Component</div>
                        <div class="row">
                            <div class="col-md-12" v-if="product_component.variants.length > 0">
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Variant name</label>
                                    <v-autocomplete
                                    v-model="variant_id"
                                    dense
                                    filled
                                    solo
                                    clearable
                                    :items="product_component.variants"
                                    item-text="variation_name"
                                    item-value="id"
                                    placeholder="Select variantion"
                                    @change="changeVariation()"
                                    ></v-autocomplete>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Ingredient name</label>
                                    <v-autocomplete
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
                                </div>
                                <div class="form-group">
                                <label class="col-form-label pt-0">Quantity</label>
                                    <div class="input-group">
                                        <input class="form-control" min="0.001" step="any" type="number" placeholder="Quantity" v-model="quantity">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{getUnit}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button v-if="!editmode" class="btn btn-sm btn-primary" type="submit" style="color: #fff">Add</button>
                                    <button v-if="editmode" @click="cancelUpdate()" class="btn btn-sm btn-danger" type="button" style="color: #fff">Cancel</button>
                                    <button v-if="editmode" class="btn btn-sm btn-primary" type="submit" style="color: #fff">Update</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </v-card>
                </div>
                <div class="col-md-8">
                    <v-card class="p-2">
                        <div class="card-title">Product Components</div>
                        <v-data-table
                            :headers="headers"
                            :items="components"
                            hide-default-footer
                            :sort-by="['variation_name']"
                            :sort-desc="[false]"
                            class="elevation-1"
                        >
                        <template v-slot:[`item.actions`]="{ item }">
                            <button 
                                class="btn btn-primary btn-sm" @click="editComponent(item)"><i class="fas fa-edit"></i>
                            </button>
                             <button 
                                class="btn btn-danger btn-sm" @click="deleteComponent(item)"><i class="fas fa-trash-alt"></i>
                            </button>
                            <!-- v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'product-delete'))" -->
                                
                        </template>
                        </v-data-table>
                    <div class="d-flex justify-content-end mt-2">
                        <button @click="submitProductComponent()" class="btn btn-primary" type="submit" style="color: #fff">Submit</button>
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
    name: 'Show',
    mounted() {
        this.getIngredients()
        this.getExistingComponents()
        // console.log(this.product_component)

    }, 
    data() {
        return {
            headers: [
            {
                text: 'Ingredient name',
                align: 'start',
                value: 'name',
            },
            { text: 'Variant name', value: 'variation_name' },
            { text: 'Quantity', value: 'quantity' },
            { text: 'unit', value: 'unit' },
            { text: 'Actions', value: 'actions' },
            ],
            index: null,
            product_id: '',
            editmode: false,
            ids: [],
            id: null,
            name: null,
            ingredient_id: null,
            variation_name: null,
            variant_id: null,
            quantity: null,
            unit: null,
            errors: {},
            search: '',
            components: [],
            filter: {}
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
        getExistingComponents() {
            var data = this.product_component.product_components
            data.forEach(component => {
                var variant_name = this.product_component.variants.filter(variant => {
                    return variant.id == component.variant_id
                })
                this.components.push({
                    id: component.id,
                    variation_name: variant_name[0].variation_name,
                    variant_id: component.variant_id,
                    product_id: this.product_component.id,
                    name: component.ingredient.name,
                    ingredient_id: component.ingredient_id,
                    quantity: component.quantity,
                    unit: component.unit,
                })
                this.ids.push(component.id)
            })
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
            if (this.quantity && this.ingredient_id && this.name) {
                this.components.push({
                    id: null,
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
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Please fill up all the required fields',
                    showConfirmButton: false,
                    timer: 1500
                    })
            }
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
                this.$store.dispatch("updateProductComponent", this.components)
                .then(response => {
                    if (response.success) {
                        Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                        })
                        this.$emit('back', 'List')
                    }
                })
            }
        })
        },

        editComponent(component) {
            this.editmode = true 
            this.index = this.ids.indexOf(component.id)
            this.id = component.id
            this.name = component.name
            this.variant_id = component.variant_id
            this.variation_name = component.variation_name
            this.ingredient_id = component.ingredient_id
            this.quantity = component.quantity
            this.unit = component.unit
        },
        clear() {
            setInterval(() => this.editmode = false, 500)
            this.id = null
            this.index = null
            this.ingredient_id = null
            this.name = null
            this.variant_id = null
            this.variation_name = null
            this.quantity = null
            this.unit = null
        },
        updateProductComponent() {
            Swal.fire({
            title: 'Are you sure?',
            text: "Update this product component",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                var data = {
                    id: this.id,
                    ingredient_id: this.ingredient_id,
                    variant_id: this.variant_id,
                    quantity: this.quantity,
                }
                this.$store.dispatch("updateComponentIndividual", data)
                .then(response => {
                    if (response.success) {
                        this.components[this.index].name = this.name
                        this.components[this.index].variation_name = this.variation_name
                        this.components[this.index].variant_id = this.variant_id
                        this.components[this.index].ingredient_id = this.ingredient_id
                        this.components[this.index].quantity = this.quantity
                        this.components[this.index].unit = this.unit
                        this.clear()
                    }
                })
             }
          })
        },
        cancelUpdate() {
            this.clear()
        },
        deleteComponent(data) {
            this.index = this.ids.indexOf(data.id)
            Swal.fire({
            title: 'Are you sure?',
            text: "Delete this product component",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.$store.dispatch("deleteProductComponent", data)
                .then(response => {
                    if (response.success) {
                        this.components.splice(this.index, 1)
                        Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                        })
                    }
                })
             }
          })
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