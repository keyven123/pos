<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="submitAllInventories()">
                <form @submit.prevent="editmode ? updateInventory() : addInventory()">
                    <div class="form-row">
                        <div class="col-4">
                            <label class="col-form-label pt-0">Ingredient Name </label><span class="text-danger"> *</span>
                            <v-autocomplete
                                v-model="ingredient_id"
                                :items="allIngredients"
                                dense
                                solo
                                clearable
                                item-text="name"
                                item-value="id"
                                @change="checkUnit(ingredient_id)"
                                placeholder="Select Ingredient"
                            ></v-autocomplete>
                            <label v-if="error" class="text-danger">The ingredient name field is required</label>
                        </div>
                        <div class="col-4">
                            <label class="col-form-label pt-0">Quantity </label><span class="text-danger"> *</span>
                            <div class="input-group">
                                <input class="form-control" type="number" step="any" min="0" placeholder="Add quantity" v-model="quantity">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{this.unit}}</span>
                                </div>
                            </div>
                            <label v-if="error" class="text-danger">The quantity field is required</label>
                        </div>
                    </div>
                    <div>
                        <button v-if="!editmode" class="btn btn-sm btn-primary" type="submit" style="color: #fff">Add</button>
                        <button v-if="editmode" class="btn btn-sm btn-danger" type="button" @click.prevent="cancelInventory()" style="color: #fff">Cancel</button>
                        <button v-if="editmode" class="btn btn-sm btn-primary" type="submit" style="color: #fff">Update</button>
                    </div>
                </form>
            <div class="form-row">
                <div class="col-md-12">
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">Ingredient Name</th>
                            <th class="text-left">Quantity</th>
                            <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in inventories" :key="index">
                            <td>{{ getIngredientName(item.ingredient_id, index) }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" type="button" @click="selectInventory(item, index)" style="color: #fff"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-danger btn-sm" type="button" @click="deleteInventory(index)"><i class="fas fa-trash-alt"></i></button>
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
    name: 'Create',
    mounted() {
        this.load()
    },
    data() {
        return {
            inventory_index: null,
            editmode: false,
            ingredient_id: null,
            quantity: null,
            error: false,
            search: '',
            inventories: [],
            unit: null
        }
    },
    methods: {
        ...mapActions({
            createInventory: "createInventory",
            getAllIngredients: "getAllIngredients",
        }),
        load() {
            this.getAllIngredients()
        },
        addInventory() {
            if (this.ingredient_id && this.quantity) {
                const data = {
                    ingredient_id: this.ingredient_id,
                    quantity: this.quantity,
                }
                this.inventories.push(data)
                this.ingredient_id = null
                this.quantity = null
                this.error = false
            } else {
                Swal.fire('Error', 'Please fill up all the fields' , 'error')
                this.error = true
            }
        },
        selectInventory(data, index) {
            this.editmode = true
            this.ingredient_id = data.ingredient_id
            this.quantity = data.quantity
            this.inventory_index = index

        },
        cancelInventory() {
            this.editmode = false
            this.ingredient_id = null
            this.quantity = null
        },
        updateInventory() {
            if(this.ingredient_id && this.quantity) {
                this.inventories[this.inventory_index].ingredient_id = this.ingredient_id
                this.inventories[this.inventory_index].quantity = this.quantity
                this.editmode = false
                this.ingredient_id = null
                this.quantity = null
                this.error = false
            } else {
                Swal.fire('Error', 'Please fill up all the fields' , 'error')
                this.error = true
            }

        },
        deleteInventory(index) {
            this.inventories.splice(index, 1)
        },
        submitAllInventories() {
            if(this.inventories.length > 0) {
                this.createInventory(this.inventories)
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
                    this.$emit('back', 'List')
                }).catch(error => {
                    Swal.fire('Error', error.response.data.message , error.response.data.alert_type)
                })
            } else {
                    Swal.fire('Error', 'Please add atleast 1 ingredient to proceed' , 'error')
            }
        },
        getIngredientName(data, index) {
            // let name = this.allIngredients.filter(function(element) {
            //     return element.id == data
            // })
            return this.allIngredients[index].name
        },
        checkUnit(data) {
            let unit = this.allIngredients.filter(function(element) {
                return element.id == data
            })
            this.unit = unit[0].unit
        },
        
    },
    computed: {
        ...mapGetters({
            allIngredients: "allIngredients"
        }),
    }
};
</script>

<style>

</style>