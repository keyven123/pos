<template>
  <div class="card">
    <div class="card-body">
        <v-card>
            <v-card-title>
                <h3>List of Employee</h3>
                <v-spacer></v-spacer>
                <v-text-field
                v-model="search"
                append-icon=""
                label="Search Employee List"
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
                    @click="filterByName"
                    >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="allEmployees"
                :search="search"
                @pagination="paginate"
                :server-items-length="totalEmployees"
                :options.sync="options"
                :loading="loading"
                :footer-props="{
                    'items-per-page-options': listSize
                }"
            >
            <template v-slot:[`item.image`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">
                        <v-avatar>
                        <img
                            :src="item.image ? item.image : '/images/profile/profile6.png'"
                        >
                        </v-avatar>
                    </div>
                </div>
            </template>
            <template v-slot:[`item.name`]="{ item }">
                <div class="d-flex">
                    <div class="align-items-center">{{item.first_name}} {{item.last_name}}</div>
                </div>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <button 
                    class="btn btn-primary btn-sm" @click="selectEmployee(item)"><i class="fas fa-eye"></i>
                </button>
                <button 
                    class="btn btn-success btn-sm" @click="selectHistory(item)"><i class="fas fa-search-dollar"></i>
                </button>
                <!-- <button 
                    class="btn btn-danger btn-sm" 
                    @click="deleteEmployee(item)"><i class="fas fa-trash"></i></button> -->
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
    this.getEmployees()
},
data() {
    return {
        search: '',
        filter: {},
        first_load: true,
        headers: [
            { text: 'Image', value: 'image' },
            {
                text: 'Employee name',
                align: 'start',
                filterable: false,
                value: 'name',
            },
            { text: 'Designation', value: 'designation.name' },
            { text: 'Total working days', value: 'total_working_days' },
            { text: 'Whole day', value: 'whole_day' },
            { text: 'Half day', value: 'half_day' },
            { text: 'Note counted', value: 'not_counted' },
            { text: 'Action', value: 'actions' },
            ],
        totalEmployees: 0,
        loading: true,
        options: {},
        listSize: [10, 25, 50, 100],
    }
},
methods: {
    ...mapActions({ 
        getAllEmployees: "getAllEmployees" ,
        showEmployee: "showEmployee"

    }),
    getEmployees() {
        this.getAllEmployees()
        .then(response => {
            this.loading = false;
            this.totalEmployees = response.total;
            this.options = {...this.options, itemsPerPage: response.per_page}
            setTimeout(() => {
                this.first_load = false
            }, 1000)
        })
    },
    paginate(e) {
        if(e.itemsLength !== 0 && !this.first_load) {
            this.filter = {...this.filter, page: e.page, itemsPerPage: e.itemsPerPage}
            this.getAllEmployees(this.filter)
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
    filterByName() {
        this.loading = true
        this.filter.page = 1
        this.filter.search = this.search
        this.getAllEmployees(this.filter)
        .then(response => {
            this.totalEmployees = response.total;
            this.options.page = response.current_page
            this.loading = false
        })
    },
    selectEmployee(employee) {
        this.showEmployee(employee)
        .then(() => {
            this.$emit("back", "Show");
            this.$emit("user", employee);
        });
    },
    selectHistory(employee) {
        this.showEmployee(employee)
        .then(() => {
            this.$emit("back", "History");
            this.$emit("user", employee);
        });
    }
    // deleteEmployee(employee) {
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
    //             this.$store.dispatch("deleteEmployee", employee)
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
    // }
},
    computed: {
        ...mapGetters({
            allEmployees: "allEmployees",
        }),
    }
}
</script>

<style>

</style>