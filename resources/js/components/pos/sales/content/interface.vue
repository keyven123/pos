<template>
  <div class="card">
    <v-container fluid>
    <v-card-title> Categories</v-card-title>
      <v-row dense>
        <v-col
          v-for="card in categoryImages"
          :key="card.title"
          :cols="card.flex"
        >
          <v-card>
            <a href="##" @click="chooseCategory(card.title)">
            <v-img
              :src="card.src"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              :height="card.height"
            >
              <v-card-title v-text="card.title"></v-card-title>
            </v-img>
            </a>
            <!-- <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn icon>
                <v-icon>mdi-heart</v-icon>
              </v-btn>

              <v-btn icon>
                <v-icon>mdi-bookmark</v-icon>
              </v-btn>

              <v-btn icon>
                <v-icon>mdi-share-variant</v-icon>
              </v-btn>
            </v-card-actions> -->
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <div class="row mt-4">
        <div class="col-md-8">
            <v-container fluid>
            <v-card>
            <v-card-title v-text="title"></v-card-title>
                <v-row dense>
                    <template v-if="first_load">
                        <v-col
                        v-for="(card, index) in loadProducts"
                        :key="index"
                        :cols="card.flex"
                        >
                        <v-card>
                            <a href="##">
                            <v-img
                            @click="clickProduct(card.product.id)"
                            :src="card.product.image ? card.product.image : '/images/20.jpg'"
                            class="white--text align-end"
                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                            :height="card.height"
                            >
                            <v-card-title v-text="card.product.name"></v-card-title>
                            </v-img>
                            <template v-if="card.product.hasOwnProperty('variants') && card.product.variants && selected_product == card.product.id">
                                <v-card-text>
                                <v-chip-group
                                    v-model="selection"
                                    active-class="deep-purple accent-4 white--text"
                                    column
                                >
                                    <!-- <v-chip v-for="(val,index) in card.product.variants" :key="index" @click="chooseProduct(card.product ,card.product.variants[index])">
                                        <template>{{val.variation_name}}: {{val.variation_price|currency}}</template>
                                    </v-chip> -->
                                <template v-if="card.product.variation == 1">
                                    <v-chip v-for="(val,index) in card.product.variants" :key="index" @click="chooseProduct(card.product ,card.product.variants[index])">
                                        <template>{{val.variation_name}}: {{val.variation_price|currency}}</template>
                                    </v-chip>
                                </template>
                                <template v-if="card.product.variation == 0">
                                    <v-chip @click="chooseProduct(card.product ,card.product)">
                                        <template>{{card.product.price|currency}}</template>
                                    </v-chip>
                                </template>
                                </v-chip-group>
                                </v-card-text>
                            </template>
                            </a>
                        </v-card>
                        </v-col>
                    </template>
                    <template v-if="!first_load">
                        <v-col
                        v-for="(card, index) in filtered_products"
                        :key="index"
                        :cols="card.flex"
                        >
                        <v-card>
                            <!-- <a href="#" @click="chooseProduct(card.product)"> -->
                            <a href="##">
                            <v-img
                            @click="clickProduct(card.product.id)"
                            :src="card.product.image ? card.product.image : '/images/20.jpg'"
                            class="white--text align-end"
                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                            :height="card.height"
                            >
                            <v-card-title v-text="card.product.name"></v-card-title>
                            </v-img>
                            <template v-if="card.product.hasOwnProperty('variants') && card.product.variants && selected_product == card.product.id">
                                <!-- <v-card-subtitle v-for="(val,index) in card.product.variants" :key="index" v-text="val.variation_price"></v-card-subtitle> -->
                                <v-card-text>
                                <v-chip-group
                                    v-model="selection"
                                    active-class="deep-purple accent-4 white--text"
                                    column
                                >
                                <template v-if="card.product.variation == 1">
                                    <v-chip v-for="(val,index) in card.product.variants" :key="index" @click="chooseProduct(card.product ,card.product.variants[index])">
                                        <template>{{val.variation_name}}: {{val.variation_price|currency}}</template>
                                    </v-chip>
                                </template>
                                <template v-if="card.product.variation == 0">
                                    <v-chip @click="chooseProduct(card.product ,card.product)">
                                        <template>{{card.product.price|currency}}</template>
                                    </v-chip>
                                </template>
                                </v-chip-group>
                                </v-card-text>
                            </template>
                            </a>
                        </v-card>
                        </v-col>
                    </template>
                </v-row>
            </v-card>
            </v-container>
        </div>
        <div class="col-md-4">
            <v-card-title>Cart</v-card-title>
                <v-simple-table>
                <template v-slot:default>
                <thead>
                    <tr>
                    <th class="text-left">Product</th>
                    <th class="text-left">Price</th>
                    <th class="text-left">Quantity</th>
                    <th class="text-left">Subtotal</th>
                    <th class="text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in orders" :key="index">
                    <td>{{ item.product_name }}</td>
                    <template>
                        <td>{{item.variation}}: {{ item.price|currency }}</td>
                    </template>
                    <td>
                        <v-container
                            fluid
                            class="pa-0">
                            <v-row>
                                <v-col cols="2" sm="3">
                                    <v-btn icon color="black">
                                    {{ item.quantity }}
                                    </v-btn>
                                </v-col>
                                <v-col cols="5" sm="3">
                                    <v-btn icon color="red" @click="minusQuantity(item,index)">
                                    <v-icon>mdi-minus</v-icon>
                                </v-btn>
                                </v-col>
                                <v-col
                                cols="5" sm="3" >
                                    <v-btn icon color="indigo" @click="addQuantity(index)" >
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </td>
                    <td>{{ (parseFloat(item.price)*parseInt(item.quantity))|currency }}</td>
                    <td>
                        <button v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'sales-delete'))"
                            class="btn btn-danger btn-sm" type="button" @click="removeProduct(index)"><i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                    </tr>
                </tbody>
                </template>
            </v-simple-table>
            
            <div class="m-2">
                <label for="amount_received">Amount Received</label>
                <input type="number" min="0" step="any" v-model="amount_received" class="form-control">
            </div>
            <div class="m-2">
                <div><h4>Change: {{amountChange|currency}}</h4></div>
            </div>
            <div class="d-flex justify-content-between m-2">
                <div><h4 class="pt-3">Total: {{totalPrice|currency}}</h4></div>
                <div>
                    <v-btn v-if="!editmode" :disabled="(orders.length == 0)" @click="submitOrder()" depressed color="primary" > Submit </v-btn>
                    <v-btn v-if="editmode" @click="orders = [], editmode = false" depressed color="error" > Cancel </v-btn>
                    <v-btn v-if="editmode" @click="UpdateOrder()" depressed color="primary" > Update </v-btn>
                </div>
            </div>
            <v-card-title>Ongoing Orders</v-card-title>
            <v-simple-table>
            <template v-slot:default>
                <thead>
                    <tr>
                    <th class="text-left">Ref #</th>
                    <th class="text-left">Amount</th>
                    <th class="text-left">Date/Time</th>
                    <th class="text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                    v-for="(item, index) in ongoing_order"
                    :key="index"
                    >
                    <td>{{ item.ref_no }}</td>
                    <td>{{ item.amount|currency }}</td>
                    <td>{{ item.updated_at|completeDate }}</td>
                    <td>
                        <button 
                            v-if="userAuthentication.hasOwnProperty('roles') && userAuthentication.roles !== null && userAuthentication.roles[0].permissions.some(permission => (permission.name === 'sales-edit'))"
                            class="btn btn-primary btn-sm" type="button" @click="editOrder(item.ref_no)"><i class="fas fa-edit" style="color:white"></i>
                        </button>
                    </td>
                    </tr>
                </tbody>
                </template>
            </v-simple-table>
        </div>
    </div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    mounted() {
        this.getCategories()
        this.getProducts()
        this.getCarts()
        this.$store.dispatch("authenticate")
    },
    data() {
        return {
            total: null,
            amount_received: 0,
            change: 0,
            editmode: false,
            selected_product: null,
            selection: null,
            first_load: true,
            filter: [],
            title: 'All Products',
            products: [],
            filtered_products: [],
            orders: [],
            ongoing_order: [],
            ref_no: null,
        }
    },
    methods: {
        ...mapActions({
            getAllCategories: "getAllCategories",
            getfilterCategory: "getfilterCategory",
            getAllProducts: "getAllProducts",
            createCart: "createCart",
            createOrder: "createOrder",
            getAllCarts: "getAllCarts"
        }),
        async getCategories() {
            this.filter = {...this.filter, itemsPerPage: 12}
            this.getAllCategories(this.filter)
        },
        async getProducts() {
            this.filter = {...this.filter, itemsPerPage: 200}
            this.getAllProducts(this.filter)
        },
        async getCarts() {
            this.getAllCarts()
            .then(response => {
                this.ongoing_order = response
            })
        },
        chooseCategory(item) {
            if (item == "All Products") {
                this.first_load = true
                this.title = item
            } else {
                this.first_load = false
                this.title = item
                this.filtered_products = []
                var products = []
                this.allProducts.forEach(product => {
                    if (product.category.name == item) {
                        products.push(product)
                    }
                })
                if(products.length < 4) {
                    products.forEach(product => {
                        this.filtered_products.push({product,flex:4,height:'200px'})
                    })
                } else if(products.length = 4) {
                    products.forEach(product => {
                        this.filtered_products.push({product,flex:3,height:'150px'})
                    })
                } 
                else {
                    products.forEach(product => {
                        this.filtered_products.push({product,flex:2,height:'100px'})
                    })
                }
                return this.filtered_products
            }
        },
        chooseProduct(product, data) {
            let product_exist = this.orders.some(order => (order.product_name == product.name && order.variation == data.variation_name || (order.product_name == data.name && data.variation == 0)))
            if (product_exist) {
                let index = this.orders.findIndex(order => (order.product_name == product.name && order.variation == data.variation_name || (order.product_name == data.name && data.variation == 0)))
                this.orders[index].quantity += parseInt(1)
            } else {
                this.orders.push({
                    product_id: product.id,
                    variation_id: data.variation_name ? data.id : '',
                    product_name: product.name,
                    quantity: parseInt(1),
                    variation: data.variation_name ? data.variation_name : '',
                    price: data.variation_price ? data.variation_price : data.price,
                })
            }
        },
        clickProduct(id) {
            this.selection = null
            if (this.selected_product == id) {
                this.selected_product = null
            } else {
                this.selected_product = id
            }
        },
        addQuantity(index) {
            this.orders[index].quantity += parseInt(1)
        },
        minusQuantity(order, index) {
            if(order.quantity == 1) {
                this.orders.splice(index, 1)
            } else {
                this.orders[index].quantity -= parseInt(1)
            }
        },
        removeProduct(index) {
            this.orders.splice(index, 1)
        },
        submitOrder() {
            Swal.fire({
            title: 'Are you sure?',
            text: "Place all orders?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                if(this.orders.length !== 0 && this.amount_received && this.amountChange >= 0) {
                    var final_order = []
                    var cart_history = []
                    var ref_no = moment().format('MMDYYYYhmmss');
                    var total = parseFloat(0)
                    this.orders.forEach(order => {
                        cart_history.push({
                            product_id: order.product_id,
                            variant_id: order.variation_id,
                            ref_no: ref_no,
                            price: order.price,
                            quantity: order.quantity,
                        })
                    })
                    this.orders.forEach(product => {
                        total += parseFloat(product.price)*parseInt(product.quantity)
                    })
                    final_order = {ref_no: ref_no, amount: total}
                    this.createCart(cart_history)
                    this.createOrder(final_order)
                    .then(response => {
                        Swal.fire({
                        icon: response.alert_type,
                        title: response.message+' with RN# '+response.data.ref_no,
                        showConfirmButton: true,
                        })
                        this.orders = []
                        this.getCarts()
                        })
                    } else {
                        Swal.fire('Please check the amount received')
                    }
                }
            })
        },
        editOrder(ref_no) {
            this.ref_no = ref_no
            const data = {
                ref_no: ref_no
            }
            if(this.orders.length == 0) {
                this.editmode = true
                this.$store.dispatch("showCart", data)
                .then(response => {
                    response.forEach(product => {
                        this.orders.push({
                            id: product.id,
                            ref_no: ref_no,
                            product_id: product.product_id,
                            variation_id: product.variant_id ? data.variant_id : '',
                            product_name: product.product.name,
                            quantity: product.quantity,
                            variation: product.variant_id ? product.variant.variation_name : '',
                            price: product.variant_id ? product.variant.variation_price : product.product.price,
                        })
                    })
                })
            }else {
                Swal.fire({
                icon: 'error',
                title: 'Please remove all products in the cart first before editing ongoing orders',
                showConfirmButton: true,
                })
            }
        },
        UpdateOrder() {
            Swal.fire({
            title: 'Are you sure?',
            text: "Update all orders?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                var final_order = []
                var cart_history = []
                var total = parseFloat(0)
                this.orders.forEach(order => {
                    cart_history.push({
                        id: order.id,
                        ref_no: order.ref_no,
                        product_id: order.product_id,
                        variant_id: order.variation_id,
                        price: order.price,
                        quantity: order.quantity,
                    })
                })
                this.orders.forEach(product => {
                    total += parseFloat(product.price)*parseInt(product.quantity)
                })
                final_order = {ref_no: this.ref_no, amount: total}
                this.$store.dispatch("updateCart", cart_history)
                this.$store.dispatch("updateOrder", final_order)
                .then(response => {
                    Swal.fire({
                        icon: response.alert_type,
                        title: "Order Successfully Updated with ref#: "+response.data.ref_no,
                        showConfirmButton: true,
                        })
                    this.editmode = false
                    this.orders = []
                    this.getCarts()
                })
                }
            })
        }
    },
    computed: {
        ...mapGetters({
            allCategories: "allCategories",
            allProducts: "allProducts",
            userAuthentication: "userAuthentication"
        }),
        categoryImages() {
            var categoryImages = []
                if (this.allCategories.length < 4) {
                    categoryImages.push({title:"All Products",src:"/images/jollitea-6.jpg", flex: 3,height: '150px'})
                    this.allCategories.forEach(category => {
                    categoryImages.push({
                    title: category.name,
                    src: category.image,
                    flex: 3,
                    height: '150px'
                    })
                })
                } else if(this.allCategories.length >= 3 && this.allCategories.length < 7) {
                    categoryImages.push({title:"All Products",src:"/images/jollitea-6.jpg", flex: 2,height: '150px'})
                    this.allCategories.forEach(category => {
                    categoryImages.push({
                    title: category.name,
                    src: category.image,
                    flex: 2,
                    height: '150px'
                    })
                })
                } else {
                    this.allCategories.forEach(category => {
                    categoryImages.push({title:"All Products",src:"/images/jollitea-6.jpg", flex: 1,height: '100px'})
                    categoryImages.push({
                    title: category.name,
                    src: category.image,
                    flex: 1,
                    height: '100px'
                    }) 
                })
                }
            return categoryImages
        },
        loadProducts() {
            var products = []
            if (this.allProducts.length < 4) {
                this.allProducts.forEach(product => {
                    products.push({product, flex:4, height: '200px'})
                })
            } else {
                this.allProducts.forEach(product => {
                    products.push({product, flex:3, height: '100px'})
                })
            }
            return products
        },
        totalPrice() {
            var total = parseFloat(0)
            this.orders.forEach(product => {
                total += parseFloat(product.price)*parseInt(product.quantity)
            })
            this.total = total
            return total
        },
        amountChange() {
            if (this.amount_received && this.total) {
                return parseFloat(this.amount_received) - parseFloat(this.total)
            } else {
                return 0
            }
        },
    }
}
</script>

<style>

</style>