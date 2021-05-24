import axios from 'axios'

const state = {
    roles: [],
    role: {}
}
const getters = {
    allRoles: state => state.roles,
    role: state => state.role,
}

const actions = {
    async getAllRoles({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/role`, config)
        commit('setroles', response.data.data)
        return response.data
    },
    async createRole({commit}, payload) {
        const response = await axios.post('api/role', payload)
        return response.data
    },
    async showRole({commit}, payload) {
        commit("setRole", payload)
    },
    async updateRole({getters}, payload) {
        var role = getters.role
        const response = await axios.put(`api/role/${role.id}`, payload)
        return response.data
    },
    async deleteRole({commit}, payload) {
        const response = await axios.delete(`api/role/${payload.id}`)
        if (response.data) {
            commit("deleteRole", payload)
        }
        return response.data
    }
}

const mutations = {
    setroles: (state, roles) => state.roles = roles,
    setRole: (state, role) => state.role = role,
    deleteRole: (state, role) => state.roles = state.roles.filter(element => (element.id !== role.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}