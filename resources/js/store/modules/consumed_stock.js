import axios from 'axios'

const state = {
    consumed_stocks: []
}
const getters = {
    allConsumedStocks: state => state.consumed_stocks
}
const actions = {
    async getAllConsumedStocks({commit}, payload) {
        const response = await axios.get('consumed-stocks')
        return response
    },
    async createConsumedStocks({commit}, payload){
        const response = await axios.post('api/consumed-stocks', payload)
        return response.data
    }

}

const mutations = {
    setConsumedStocks: (state, consumed_stocks) => state.consumed_stocks = consumed_stocks
}

export default {
    state,
    getters,
    actions,
    mutations
}