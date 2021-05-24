import axios from 'axios'

const state = {
    carts: [],
    cart: {}
}
const getters = {
    allCarts: state => state.carts,
    cart: state => state.cart,
}

const actions = {
    async getAllCarts({commit}) {
        const response = await axios.get(`api/cart-history`)
        commit('setCarts', response.data.data)
        return response.data
    },
    async createCart({commit}, payload) {
        const response = await axios.post('api/cart-history', payload)
        return response.data
    },
    async showCart({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/showCart', config)
        commit("setCart", response.data)
        return response.data
    },
    async updateCart({getters}, payload) {
        const response = await axios.post(`api/updateCart`, payload)
        return response.data
    },
    async deleteCart({commit}, payload) {
        const response = await axios.delete(`api/cart-history/${payload.id}`)
        if (response.data) {
            commit("deleteCart", payload)
        }
        return response.data
    }
}

const mutations = {
    setCarts: (state, carts) => state.carts = carts,
    setCart: (state, cart) => state.cart = cart,
    deleteCart: (state, cart) => state.carts = state.carts.filter(element => (element.id !== cart.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}