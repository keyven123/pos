import axios from 'axios'

const state = {
    inventories: [],
    inventory: {},
    history: []
}
const getters = {
    allInventories: state => state.inventories,
    inventory: state => state.inventory,
    allHistory: state => state.history
}

const actions = {
    async getAllHistory({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/getAllHistory', config)
        commit("setHistory", response.data.data)
        return response.data
    },
    async getCartComputation({commit},) {
        const response = await axios.get('api/getCartComputation')
        return response.data
    },
    async getAllInventories({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/inventory`, config)
        commit('setInventories', response.data.data)
        return response.data
    },
    async createInventory({commit}, payload) {
        const response = await axios.post('api/inventory', payload)
        return response.data
    },
    async showInventory({commit}, payload) {
        return commit("setInventory", payload)
        
    },
    async showSpecificInventory({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/showSpecificInventory', config)
        commit("setInventories", response.data.data)
        return response.data
    },
    async updateInventory({getters}, payload) {
        var inventory = getters.inventory
        const response = await axios.put(`api/inventory/${inventory.id}`, payload)
        return response.data
    },
    async deleteInventory({commit}, payload) {
        const response = await axios.delete(`api/inventory/${payload.id}`)
        if (response.data) {
            commit("deleteInventory", payload)
        }
        return response.data
    }
}

const mutations = {
    setHistory: (state, history) => state.history = history,
    setInventories: (state, inventories) => state.inventories = inventories,
    setInventory: (state, inventory) => state.inventory = inventory,
    deleteInventory: (state, inventory) => state.inventories = state.inventories.filter(element => (element.id !== inventory.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}