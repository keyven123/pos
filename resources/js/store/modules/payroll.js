import axios from 'axios'

const state = {
    payrolls: [],
}

const getters = {
    payrolls: state => state.payrolls
}

const actions = {
    async getAllPayrolls({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/payroll')
        commit("setPayrolls", response.data.data)
        return response.data
    },
    async createPayroll({commit}, payload) {
        const response = await axios.post('api/payroll', payload)
        return response.data
    }
}

const mutations = {
    setPayrolls: (state, payrolls) => state.payrolls = payrolls
}

export default {
    state,
    getters,
    actions,
    mutations
}