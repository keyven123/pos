<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>List of Users</h3>
                <v-btn v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'user-management-create'))"
                color="primary"
                class="mb-2 ml-6"
                fab
                x-small
                @click="showCreateForm"
                >
                <v-icon>
                    mdi-plus
                </v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <v-text-field
                v-model="search"
                append-icon=""
                label="Search product"
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
                    @click="filterProductByName"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="allUsers"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalProducts"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:[`item.date_hire`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center h-100">{{item.date_hire|myDate}}</div>
                </div>
            </template>
            <template v-slot:[`item.created_at`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center h-100">{{item.created_at|myDate}}</div>
                </div>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'user-management-edit'))"
                    class="btn btn-primary btn-sm" 
                    @click="selectUser(item)"><i class="fas fa-eye"></i></button>
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'user-management-delete'))"
                    class="btn btn-danger btn-sm" 
                    @click="deleteUser(item)"><i class="fas fa-trash"></i></button>
            </template>
            </v-data-table>
        </v-card>
    </div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: "List",
    created() {
        this.load()
        this.$store.dispatch("authenticate")
    },
    data() {
        return {
            search: '',
            filter: {},
            first_load: true,
            headers: [
                {
                    text: 'First name',
                    align: 'start',
                    filterable: false,
                    value: 'first_name',
                },
                { text: 'Last Name', value: 'last_name' },
                { text: 'Designation', value: 'designation.name' },
                { text: 'Email Address', value: 'email' },
                { text: 'Username', value: 'username' },
                { text: 'Contact', value: 'contact' },
                { text: 'Created at', value: 'created_at' },
                { text: 'Date Hired', value: 'date_hire' },
                { text: "Actions", value: "actions" }
                ],
            totalProducts: 0,
            loading: true,
            options: {},
            listSize: [10, 25, 50, 100],
        }
    },
    methods: {
        ...mapActions({
            getAllUsers: "getAllUsers",
            showUser: "showUser"
        }),
        load() {
            this.getUsers()
        },
        getUsers() {
            this.getAllUsers()
            .then(response => {
                this.loading = false;
                this.totalProducts = response.total;
                this.options = {...this.options, itemsPerPage: response.per_page}
                setTimeout(() => {
                    this.first_load = false
                }, 1000)
            }) 
        },
        paginate(e) {
            if(e.itemsLength !== 0 && !this.first_load) {
                this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
                this.getAllUsers(this.filter)
                .then(response => {
                    this.loading = false
                })
            }
        },
        clearFilter(e) {
            console.log(e)
        },
        filterProductByName() {
            this.loading = true
            this.filter.page = 1
            this.filter.search = this.search
            this.getAllUsers(this.filter)
            .then(response => {
                this.totalUsers = response.total;
                this.options.page = response.current_page
                this.loading = false
            })
        },
        showCreateForm() {
            this.$emit('back', 'Create')
        },
        selectUser(user) {
            this.showUser(user)
            .then(() => {
                this.$emit('back', 'Show');
            })
        },
        deleteUser(user) {
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
                    this.$store.dispatch("deleteUser", user)
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
            allUsers: "allUsers",
            userAuthentication: "userAuthentication"
        })
    }
}
</script>

<style>

</style>