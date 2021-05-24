import axios from 'axios'

const state = {
    data: [],
    chart: [],
    filter: [],
    carts: [],
    inventories: [],
    sparkline: []
}
const getters = {
    getData: state => state.data,
    getChart: state => state.chart,
    getFilter: state => state.filter,
    getCarts: state => state.carts,
    getInventories: state => state.inventories,
    getSparkline: state => state.sparkline
}
const actions = {
    async getAllData({commit}) {
        const response = await axios.get('api/dashboard/getAllData')
        commit("setData", response.data)
        return response.data
    },
    async getAllChart({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/dashboard/getChartData', config)
        commit("setChart", response.data)
        return response.data
    },
    async getFilterData({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/dashboard/filterBy', config)
        commit("setFilter", response.data)
        return response.data
    },
    async getTableCarts({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/dashboard/getTableCarts', config)
        commit("setCarts", response.data.data)
        return response.data
    },
    async getAllInventory({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/dashboard/getAllInventory', config)
        commit("setInventories", response.data.data)
        return response.data
    },
    async getAllSparkLine({commit}) {
        const response = await axios.get('api/dashboard/getAllSparkLine')
        commit("setSparkline", response.data)
        return response.data
    }
}
const mutations = {
    setData: (state, data) => state.data = data,
    setChart: (state, chart) => state.chart = chart,
    setFilter: (state, filter) => state.filter = filter,
    setCarts: (state, carts) => state.carts = carts,
    setInventories: (state, inventories) => state.inventories = inventories,
    setSparkline: (state, sparkline) => state.sparkline = sparkline
}

export default {
    state,
    getters,
    actions,
    mutations
}