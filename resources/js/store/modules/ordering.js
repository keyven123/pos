import axios from 'axios'

const state = {
    queues: [],
}
const getters = {
    allQueues: state => state.queues,
}

const actions = {
    async getAllQueues({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/getOrders`, config)
        commit('setQueues', response.data.data)
        return response.data
    },
    async doneOrder({commit}, payload) {
        const response = await axios.post('api/doneOrder', payload)
    }
}

const mutations = {
    setQueues: (state, queues) => state.queues = queues,
}

export default {
    state,
    getters,
    actions,
    mutations
}