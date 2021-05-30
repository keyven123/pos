<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>List of Order</h3>
                <!-- <v-btn color="primary"
                class="mb-2 ml-6"
                fab
                x-small
                @click="showCreateForm"
                >
                <v-icon>
                    mdi-plus
                </v-icon>
                </v-btn> -->
                <v-spacer></v-spacer>
                <v-text-field
                v-model="search"
                append-icon=""
                label="Search Order"
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
                    @click="filterOrderByName"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="allOrders"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalOrders"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:[`item.status`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center" style="color:#005cb9" v-if="item.status==0">Preparing</div>
                    <div class="align-items-center" style="color:green" v-if="item.status==1">To Received</div>
                    <div class="align-items-center" v-if="item.status==2">Success</div>
                </div>
            </template>
            <template v-slot:[`item.amount`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.amount|currency}}</div>
                </div>
            </template>
            <template v-slot:[`item.user.first_name`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.user.first_name}} {{item.user.last_name}}</div>
                </div>
            </template>
            <template v-slot:[`item.created_at`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.created_at|myDate}}</div>
                </div>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'order-view'))"
                    class="btn btn-primary btn-sm" 
                    @click="selectOrder(item)"><i class="fas fa-eye"></i></button>
                <!-- <button 
                    class="btn btn-danger btn-sm" 
                    @click="deleteOrder(item)"><i class="fas fa-trash"></i></button> -->
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
    this.getOrders()
    this.$store.dispatch("authenticate")
},
data() {
    return {
        order: '',
        search: '',
        filter: {},
        first_load: true,
        headers: [
            {
                text: 'Reference number',
                align: 'start',
                filterable: false,
                value: 'ref_no',
            },
            { text: 'Status', value: 'status' },
            { text: 'Amount', value: 'amount' },
            { text: 'Cashier', value: 'user.first_name' },
            { text: 'Created at', value: 'created_at' },
            { text: "Actions", value: "actions" }
            ],
        totalOrders: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getAllOrders: "getAllOrders" ,
        showOrder: "showOrder"

    }),
    getOrders() {
        this.getAllOrders()
        .then(response => {
            this.loading = false;
            this.totalOrders = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.getAllOrders(this.filter)
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
    filterOrderByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllOrders(this.filter)
        .then(response => {
            this.totalOrders = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectOrder(order) {
        this.showOrder(order)
        .then(() => {
            this.$emit("back", "Show");
        });
    },
    deleteOrder(order) {
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
                this.$store.dispatch("deleteOrder", order)
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
            allOrders: "allOrders",
            userAuthentication: "userAuthentication"
        }),
    }
}
</script>

<style>

</style>