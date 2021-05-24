<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>List of Roles</h3>
                <v-btn v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'role-create'))"
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
                label="Search Role"
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
                    @click="filterRoleByName"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="allRoles"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalRoles"
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
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'role-edit'))"
                    class="btn btn-primary btn-sm" 
                    @click="selectRole(item)"><i class="fas fa-edit"></i></button>
                <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'role-delete'))"
                    class="btn btn-danger btn-sm" 
                    @click="deleteRole(item)"><i class="fas fa-trash"></i></button>
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
    this.getRoles()
    this.$store.dispatch("authenticate")
},
data() {
    return {
        search: '',
        filter: {},
        first_load: true,
        headers: [
            {
                text: 'Roles',
                align: 'start',
                filterable: false,
                value: 'name',
            },
            { text: 'Created at', value: 'created_at' },
            { text: "Actions", value: "actions" }
            ],
        totalRoles: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getAllRoles: "getAllRoles" ,
        showRole: "showRole",

    }),
    getRoles() {
        this.getAllRoles()
        .then(response => {
            this.loading = false;
            this.totalRoles = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.getAllRoles(this.filter)
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
    filterRoleByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllRoles(this.filter)
        .then(response => {
            this.totalRoles = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectRole(role) {
        this.showRole(role)
        .then(() => {
            this.$emit("back", "Show");
        });
    },
    deleteRole(role) {
        this.$store.dispatch("deleteRole", role)
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
},
    computed: {
        ...mapGetters({
            allRoles: "allRoles",
            userAuthentication: "userAuthentication"
        }),
    }
}
</script>

<style>

</style>