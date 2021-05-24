<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>List of Inventory</h3>
                <v-menu
                v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'inventory-create'))"
                    bottom
                    rounded="lg"
                    offset-y
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            color="info"
                            class="margin-bottom-8 margin-left-20 mb-2 ml-6"
                            fab
                            x-small
                            dark
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon>mdi-menu-down</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item
                            v-for="(item, index) in add_types"
                            :key="index"
                            @click="addItem(item)"
                            class="cursor-pointer"
                        >
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
                <v-spacer></v-spacer>
                <v-text-field
                v-model="search"
                append-icon=""
                label="Search Inventory"
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
                    @click="filterInventoryByName"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="allInventories"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalInventories"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:[`item.inventories_sum_quantity`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.inventories_sum_quantity|unit}}</div>
                </div>
            </template>
            <template v-slot:[`item.stocks_left`]="{ item }">
                <div class="d-flex">
                    <div v-if="stocksLeft(item) < item.warning_level" class="align-items-center text-danger">{{stocksLeft(item)}}</div>
                    <div v-if="stocksLeft(item) >= item.warning_level" class="align-items-center">{{stocksLeft(item)}}</div>
                </div>
            </template>
            <template v-slot:[`item.updated_at`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.updated_at|myDate}}</div>
                </div>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'inventory-edit'))"
                    class="btn btn-primary btn-sm" 
                    @click="selectInventory(item)"><i class="fas fa-eye"></i></button>
                <!-- <button 
                    class="btn btn-danger btn-sm" 
                    @click="deleteInventory(item)"><i class="fas fa-trash"></i></button> -->
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
    this.getInventory()
    this.getStockDeduction()
    this.$store.dispatch("authenticate")
},
data() {
    return {
        search: '',
        filter: {},
        first_load: true,
        add_types: [
            { title: 'Add Inventories' },
            { title: 'Add Ingredients' },
            { title: 'Show History' },
        ],
        headers: [
            {
                text: 'Ingredient name',
                align: 'start',
                filterable: false,
                value: 'name',
            },
            { text: 'Accumulated stocks', value: 'inventories_sum_quantity' },
            { text: 'stocks left', value: 'stocks_left' },
            { text: 'Unit', value: 'unit' },
            { text: 'Updated at', value: 'updated_at' },
            { text: "Actions", value: "actions" }
            ],
        totalInventories: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
        carts: [],
    }
},
methods: {
    ...mapActions({ 
        getAllInventories: "getAllInventories" ,
        showInventory: "showInventory"
    }),
    addItem(value) {
        if(value.title == 'Add Inventories'){
            this.$emit('back', 'Create')
        }else if (value.title == 'Show History') {
            this.$emit('back', 'History')
        }
        else{
            this.$emit('back', 'Ingredients')
        }
    },
    async getStockDeduction() {
        this.$store.dispatch("getCartComputation")
        .then(response => {
            this.carts = response
        })
    },
    getInventory() {
        this.getAllInventories()
        .then(response => {
            this.loading = false;
            this.totalInventories = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.getAllInventories(this.filter)
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
    filterInventoryByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllInventories(this.filter)
        .then(response => {
            this.totalInventories = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectInventory(inventory) {
        this.showInventory(inventory)
        .then(() => {
            this.$emit("back", "Show");
        });
    },
    stocksLeft(data) {
        if (data.consumed_stocks_sum_quantity) {
            return parseFloat(data.inventories_sum_quantity).toFixed(3) - parseFloat(data.consumed_stocks_sum_quantity).toFixed(3)
        } else {
            return parseFloat(data.inventories_sum_quantity).toFixed(3)
        }
    }
    // deleteInventory(inventory) {
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!'
    //         }).then((result) => {
    //         if (result.isConfirmed) {
    //             this.$store.dispatch("deleteInventory", inventory)
    //             .then(response => {
    //                 Swal.fire({
    //                 position: 'top-end',
    //                 icon: response.alert_type,
    //                 title: response.message,
    //                 showConfirmButton: false,
    //                 timer: 1500
    //                 })
    //             })
    //         }
    //     })
    // },
    // stocksLeft(data) {
    //     var sub = this.carts.filter(cart => {
    //         return cart.ingredient_id == data.id
    //     })
    //     var inventories_sum_quantity= parseFloat(data.inventories_sum_quantity)
    //     var total = parseFloat(0)
    //     sub.forEach(subtract => {
    //         return total += (parseFloat(subtract.ch_quantity) * parseFloat(subtract.pc_quantity))
    //     })
    //     return inventories_sum_quantity - total
    // }
},
    computed: {
        ...mapGetters({
            allInventories: "allInventories",
            userAuthentication: "userAuthentication"
        }),
    }
}
</script>

<style>

</style>