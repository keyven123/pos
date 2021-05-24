<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <div class="row">
                <div class="col-md-3">Reference#: {{ref_no}}</div>
                <div class="col-md-3">Total: {{amount|currency}}</div>
                <div class="col-md-3">Date: {{created_at|myDate}}</div>
            </div>
            <v-simple-table>
            <template v-slot:default>
            <thead>
                <tr>
                <th class="text-left">Product Name</th>
                <th class="text-left">Variant</th>
                <th class="text-left">Price</th>
                <th class="text-left">Quantity</th>
                <th class="text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr
                v-for="(item, index) in cart_histories"
                :key="index"
                >
                <td>{{ item.product.name }}</td>
                <td>{{ item.variant.variation_name }}</td>
                <td>{{ item.price|currency }}</td>
                <td>{{ item.quantity }}</td>
                <td>{{ (item.price*item.quantity)|currency }}</td>
                </tr>
            </tbody>
            </template>
        </v-simple-table>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Create',
    mounted() {
        this.fillForm()
    },
    data() {
        return {
            amount: null,
            ref_no: null,
            created_at: null,
            cart_histories: [],
            user: [],
            errors: {},
            search: '',
        }
    },
    methods: {
        async fillForm() {
            this.amount = await this.order.amount
            this.ref_no = await this.order.ref_no
            this.created_at = await this.order.created_at
            this.cart_histories = await this.order.cart_histories
            this.user = await this.order.user

        },
    },
    computed: {
        ...mapGetters({
            order: "order"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>