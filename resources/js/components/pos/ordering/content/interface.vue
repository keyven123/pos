<template>
  <div class="card">
      <div class="card-body">
        <div class="card-title">Preparing: <span style="color:#005cb9">BLUE</span> , RECEIVING: <span style="color:green">GREEN</span></div>
        <v-row>
            <v-col
            v-for="d in data"
            :key="d.id"
            cols="12"
            :md="(data.length < 5) ? '4' : '3'"
            sm="6"
            >
            <a href="#">
                <div :class="cardColor(d)" @click="orderReceived(d)">
                    <div class="card-title">
                        <h4 class="white--text">Ref#: {{d.ref_no}}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="white--text p-0 m-0 d-flex justify-content-between" v-for="(cart, index) in d.cart_histories" :key="index">
                            <div>{{cart.product.name}} </div>
                            <div> {{cart.variant.variation_name }}  {{cart.quantity}}x</div>
                        </div>
                        <hr>
                        <div class="white--text subtitle-1 d-flex justify-content-end" text="20">
                            <h4><b>{{d.amount|currency}}</b></h4>
                        </div>
                    </div>
                </div>
            </a>
            </v-col>
        </v-row>
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
        orderReceived(item) {
            console.log(item)
            Swal.fire({
            title: 'Are you sure?',
            text: (item.status==0) ? "Move to customer order collection?" : "Customer Received the order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                if (item.status == 0) {
                    const data = {
                        id: item.id,
                        ref_no: item.ref_no,
                        status: 1
                    }
                    this.doneOrder(data)
                    .then(response => {
                        this.getOrders()
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Order is ready to collect!',
                        })
                    })
                } else if (item.status == 1) {
                    const data = {
                        id: item.id,
                        ref_no: item.ref_no,
                        status: 2
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
            }
        })
        },
        cardColor(item) {
            if (item.status == 0) {
                return 'card blue px-3 pt-3 pb-0 m-0'
            } else {
                return 'card green px-3 pt-3 pb-0 m-0'
            }
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