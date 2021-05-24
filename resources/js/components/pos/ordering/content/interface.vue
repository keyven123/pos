<template>
  <div class="card">
      <div class="card-body">
          <div class="card-title">Preparing</div>
          <v-card>
            <v-item-group>
                <v-container>
                <v-row>
                    <v-col
                    v-for="d in data"
                    :key="d.id"
                    cols="12"
                    :md="(d.length < 5) ? '4' : '3'"
                    sm="6"
                    >
                    <v-item>
                        <v-card
                        :color="'primary'"
                        class="d-flex align-center"
                        dark
                        height="250"
                        @click="orderReceived(d.ref_no)"
                        >
                        <v-card-text>
                        <h4 class="white--text d-flex align-items-start">Ref#: {{d.ref_no}}</h4>
                        <v-row class="mx-0 my-2">
                            <div class="white--text" v-for="(cart, index) in d.cart_histories" :key="index">
                            <h4>{{cart.product.name}} {{cart.variant.variation_name}} {{cart.quantity}}x</h4>
                            </div>
                        </v-row>

                        <div class="white--text my-4 subtitle-1 d-flex justify-content-end" text="20">
                            <h4><b>{{d.amount|currency}}</b></h4>
                        </div>
                        </v-card-text>
                        </v-card>
                    </v-item>
                    </v-col>
                </v-row>
                </v-container>
            </v-item-group>
          </v-card>
      </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    mounted() {
        this.getOrders()
        setInterval(() => this.getOrders(), 5000)
    },
    data() {
        return {
            data: [],
        }
    },
    methods: {
        ...mapActions({
            getAllQueues: "getAllQueues",
            doneOrder: "doneOrder"
        }),
        getOrders() {
            this.getAllQueues()
            .then(response => {
                this.data = response.data
            })
        },
        orderReceived(ref_no) {
            Swal.fire({
            title: 'Are you sure?',
            text: "Customer Received the order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                const data = {
                    ref_no: ref_no,
                }
                this.$store.dispatch("createConsumedStocks", data)
                this.doneOrder(data)
                .then(response => {
                    this.getOrders()
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Order Received!',
                    })
                })
            }
        })
        }
    },
    computed: {
        ...mapGetters ({
            setQueues: "setQueues"
        })
    }
}
</script>

<style>

</style>