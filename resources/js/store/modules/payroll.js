import axios from 'axios'

const state = {
    payrolls: [],
    payroll: [],
    show_payroll: {}
}

const getters = {
    payrolls: state => state.payrolls,
    payroll: state => state.payroll,
    show_payroll: state => state.show_payroll

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
    },
    async showPayroll({commit}, payload) {
        commit("showPayroll", payload)
    },
    async getPayroll({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/payroll/getPayroll', config)
        commit("setPayroll", response.data.data)
        return response.data
    }
}

const mutations = {
    setPayrolls: (state, payrolls) => state.payrolls = payrolls,
    setPayroll: (state, payroll) => state.payroll = payroll,
    showPayroll: (state, show_payroll) => state.show_payroll = show_payroll
}

export default {
    state,
    getters,
    actions,
    mutations
}