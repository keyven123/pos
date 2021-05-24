<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <v-card>
                <v-card-title>
                    <h3>List of {{inventory.name}}</h3>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="allInventories"
                    @pagination="paginate"
                    :server-items-length="totalInventories"
                    :options.sync="options"
                    :loading="loading"
                    :footer-props="{
                        'items-per-page-options': listSize
                    }"
                >
                <template v-slot:[`item.user_name`]="{ item }">
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
                    <button 
                        class="btn btn-primary btn-sm" 
                        @click="selectCategory(item)"><i class="fas fa-edit"></i></button>
                    <button 
                        class="btn btn-danger btn-sm" 
                        @click="deleteCategory(item)"><i class="fas fa-trash"></i></button>
                </template>
                </v-data-table>
            </v-card>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Create',
    mounted() {
        this.getInventory()
    },
    data() {
        return {
            filter: {},
            first_load: true,
            headers: [
                {
                    text: 'Ingredient name',
                    align: 'start',
                    filterable: false,
                    value: 'ingredient.name',
                },
                { text: "Added by", value: "user_name" },
                { text: "Quantity", value: "quantity" },
                { text: "Unit", value: "ingredient.unit" },
                { text: 'Created at', value: 'created_at' }
                ],
            totalInventories: 0,
            loading: true,
            options: {},
            listSize: [10, 25, 50, 100],
            errors: {},
            
        }
    },
    methods: {
        ...mapActions({ 
            showSpecificInventory: "showSpecificInventory"

        }),
        getInventory() {
            var data = {
                id: this.inventory.id
            }
            this.showSpecificInventory(data)
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
                this.showSpecificInventory(this.filter)
                .then(response => {
                    this.loading = false
                })
            }
        },
    },
    computed: {
        ...mapGetters({
            inventory: "inventory",
            allInventories: "allInventories"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>