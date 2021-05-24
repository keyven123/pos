<template>
<div class="row row-sm row-deck">
    <div class="col-sm 12 col-md-6 col-lg-6 col-xl-6">
        <div class="card card-table-two">
            <v-card-title>
                <h3>Your Most Recent Orders</h3>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="getCarts"
                @pagination="paginate"
                :server-items-length="totalCarts"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:[`item.variant.variation_name`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{(item.variant) ? (item.variant.variation_name) : 'N/A'}}</div>
                </div>
            </template>
            <template v-slot:[`item.price`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.price|currency}}</div>
                </div>
            </template>
            <template v-slot:[`item.total`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.total|currency}}</div>
                </div>
            </template>
            <template v-slot:[`item.created_at`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.created_at|myDate}}</div>
                </div>
            </template>
            </v-data-table>
        </div>
    </div>
    <div class="col-sm 12 col-md-6 col-lg-6 col-xl-6">
        <div class="card card-table-two">
            <v-card-title>
                <h3>Inventory</h3>
            </v-card-title>
            <v-data-table
                :headers="headers2"
                :items="getInventories"
                @pagination="paginate2"
                :server-items-length="totalInventory"
                :options.sync="options2"
                :loading="loading2"
                :footer-props="{
                    'items-per-page-options': listSize2
                }"
            >
            <template v-slot:[`item.stocks_left`]="{ item }">
                <div class="d-flex">
                    <div v-if="stocksLeft(item) < item.warning_level" class="align-items-center text-danger">{{stocksLeft(item)}}</div>
                    <div v-if="stocksLeft(item) >= item.warning_level" class="align-items-center">{{stocksLeft(item)}}</div>
                </div>
            </template>
            </v-data-table>
        </div>
    </div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    mounted() {
        this.getAllCarts()
        this.getInventory()
    },
    data() {
        return {
            search: '',
            search2: '',
            loading: true,
            loading2: true,
            carts: [],
            filter: {},
            filter2: {},
            options: {},
            options2: {},
            totalCarts: 0,
            totalInventory: 0,
            listSize: [10, 25, 50, 100],
            listSize2: [10, 25, 50, 100],
            first_load: true,
            first_load2: true,
            headers: [
            {
                text: 'reference no.',
                align: 'start',
                sortable: false,
                value: 'ref_no',
            },
            { text: 'Product name', value: 'product_name' },
            { text: 'Variant', value: 'variant.variation_name' },
            { text: 'Product price', value: 'price' },
            { text: 'Qty', value: 'quantity' },
            { text: 'Total', value: 'total' },
            { text: 'Date', value: 'created_at' },
            ],
            headers2: [
            {
                text: 'Ingredient name',
                align: 'start',
                sortable: false,
                value: 'name',
            },
            { text: 'Accumulated Stock', value: 'inventories_sum_quantity' },
            { text: 'Stock Left', value: 'stocks_left' },
            { text: 'Unit', value: 'unit' },
            ],
            inventory: [],
        }
    },
    methods: {
        ...mapActions({
            getTableCarts: "getTableCarts",
            getAllInventory: "getAllInventory"
        }),
        getInventory() {
            this.getAllInventory()
            .then(response => {
                this.loading2 = false;
                this.totalInventory = response.total;
                this.options2 = {...this.options2, itemsPerPage: response.per_page}
                setTimeout(() => {
                    this.first_load2 = false
                }, 1000)
            })
        },
        getAllCarts() {
            this.getTableCarts()
            .then(response =>{
                this.loading = false;
                this.totalCarts = response.total;
                this.options = {...this.options, itemsPerPage: response.per_page}
                setTimeout(() => {
                    this.first_load = false
                }, 1000)
            })
        },
        paginate(e) {
            if(e.itemsLength !== 0 && !this.first_load) {
                this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
                this.getTableCarts(this.filter)
                .then(response => {
                    this.loading = false
                })
            }
        },
        paginate2(e) {
            if(e.itemsLength !== 0 && !this.first_load2) {
                this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
                this.getAllInventory(this.filter)
                .then(response => {
                    this.loading2 = false
                })
            }
        },
        stocksLeft(data) {
            if (data.consumed_stocks_sum_quantity) {
                return parseFloat(data.inventories_sum_quantity).toFixed(3) - parseFloat(data.consumed_stocks_sum_quantity).toFixed(3)
            } else {
                return parseFloat(data.inventories_sum_quantity).toFixed(3)
            }
        }
    },
    computed: {
        ...mapGetters({
            getCarts: "getCarts",
            getInventories: "getInventories"
        })
    },
}
</script>

<style>

</style>