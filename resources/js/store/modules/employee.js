import axios from 'axios'

const state = {
    employees: [],
    employee: {},
    payroll_histories: []
}
const getters = {
    allEmployees: state => state.employees,
    employee: state => state.employee,
    payrollHistories: state => state.payroll_histories,
}

const actions = {
    async getAllEmployees({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/employee`, config)
        commit('setEmployees', response.data.data)
        return response.data
    },
    async createEmployee({commit}, payload) {
        const response = await axios.post('api/employee', payload)
        return response.data
    },
    async showEmployee({commit}, payload) {
        commit("setEmployee", payload)
    },
    async updateEmployee({getters}, payload) {
        var employee = getters.employee
        const response = await axios.put(`api/employee/${employee.id}`, payload)
        return response.data
    },
    async deleteEmployee({commit}, payload) {
        const response = await axios.delete(`api/employee/${payload.id}`)
        if (response.data) {
            commit("deleteEmployee", payload)
        }
        return response.data
    },
    async showPayrollHistory({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/employee/showPayrollHistory', config)
        commit('setHistories', response.data.data)
        return response.data
    }
}

const mutations = {
    setEmployees: (state, employees) => state.employees = employees,
    setEmployee: (state, employee) => state.employee = employee,
    deleteEmployee: (state, employee) => state.employees = state.employees.filter(element => (element.id !== employee.id)),
    setHistories: (state, payroll_histories) => state.payroll_histories = payroll_histories
}

export default {
    state,
    getters,
    actions,
    mutations
}