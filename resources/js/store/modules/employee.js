import axios from 'axios'

const state = {
    employees: [],
    employee: {}
}
const getters = {
    allEmployees: state => state.employees,
    employee: state => state.employee,
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
        return commit("setEmployee", payload)
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
    }
}

const mutations = {
    setEmployees: (state, employees) => state.employees = employees,
    setEmployee: (state, employee) => state.employee = employee,
    deleteEmployee: (state, employee) => state.employees = state.employees.filter(element => (element.id !== employee.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}