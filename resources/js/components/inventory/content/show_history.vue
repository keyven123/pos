<template>
  <div class="card">
    <div class="card-body">
        <div class="col-12 my-3 p-0">
            <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
        </div>
        <v-card>
            <v-card-title>
                <h3>Inventory History</h3>
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
                :items="allHistory"
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
            <template v-slot:[`item.created_at`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.created_at|completeDate}}</div>
                </div>
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
},
data() {
    return {
        search: '',
        filter: {},
        first_load: true,
        headers: [
            {
                text: 'Ingredient name',
                align: 'start',
                filterable: false,
                value: 'ingredient.name',
            },
            { text: 'Quantity', value: 'quantity' },
            { text: 'Unit', value: 'ingredient.unit' },
            { text: 'Added by', value: 'user.username' },
            { text: 'Created at', value: 'created_at' },
            ],
        totalInventories: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getAllHistory: "getAllHistory" ,
        showInventory: "showInventory"
    }),
    getInventory() {
        this.getAllHistory()
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
            this.getAllHistory(this.filter)
            .then(response => {
                this.loading = false
            })
        }
    },
    clearFilter(e) {
        console.log(e)
    },
    filterInventoryByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllHistory(this.filter)
        .then(response => {
            this.totalUsers = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
},
    computed: {
        ...mapGetters({
            allHistory: "allHistory"
        }),
    }
}
</script>

<style>

</style>