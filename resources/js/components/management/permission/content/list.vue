<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>List of Permissions</h3>
                <v-btn v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'permissions-create'))"
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
                label="Search Permissions"
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
                    @click="filterPermissionByName"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="permissions"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalPermissions"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:[`item.created_at`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.created_at|myDate}}</div>
                </div>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'permissions-edit'))"
                    class="btn btn-primary btn-sm" 
                    @click="selectPermission(item)"><i class="fas fa-edit"></i></button>
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'permissions-depete'))"
                    class="btn btn-danger btn-sm" 
                    @click="deletePermission(item)"><i class="fas fa-trash"></i></button>
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
    this.getallPermissions()
    this.$store.dispatch("authenticate")
},
data() {
    return {
        search: '',
        filter: {},
        first_load: true,
        headers: [
            {
                text: 'Category name',
                align: 'start',
                filterable: false,
                value: 'name',
            },
            { text: 'Created at', value: 'created_at' },
            { text: "Actions", value: "actions" }
            ],
        totalPermissions: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getPermissions: "getPermissions" ,
        showPermission: "showPermission"

    }),
    getallPermissions() {
        this.getPermissions()
        .then(response => {
            this.loading = false;
            this.totalPermissions = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.getPermissions(this.filter)
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
    filterPermissionByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getPermissions(this.filter)
        .then(response => {
            this.totalPermissions = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectPermission(permission) {
        this.showPermission(permission)
        .then(() => {
            this.$emit("back", "Show");
        });
    },
    deletePermission(permission) {
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
                this.$store.dispatch("deletePermission", permission)
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
            permissions: "permissions",
            userAuthentication: "userAuthentication"
        }),
    }
}
</script>

<style>

</style>