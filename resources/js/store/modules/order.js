import axios from 'axios'

const state = {
    orders: [],
    order: {}
}
const getters = {
    allOrders: state => state.orders,
    order: state => state.order,
}

const actions = {
    async getAllOrders({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/order`, config)
        commit('setOrders', response.data.data)
        return response.data
    },
    async createOrder({commit}, payload) {
        const response = await axios.post('api/order', payload)
        return response.data
    },
    async showOrder({commit}, payload) {
        return commit("setOrder", payload)
    },
    async updateOrder({getters}, payload) {
        const response = await axios.post(`api/updateOrder`, payload)
        return response.data
    },
    async deleteOrder({commit}, payload) {
        const response = await axios.delete(`api/order/${payload.id}`)
        if (response.data) {
            commit("deleteOrder", payload)
        }
        return response.data
    }
}

const mutations = {
    setOrders: (state, orders) => state.orders = orders,
    setOrder: (state, order) => state.order = order,
    deleteOrder: (state, order) => state.orders = state.orders.filter(element => (element.id !== order.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}