import axios from 'axios'

const state = {
    allPermissions: [],
    permissions: [],
    permission: {}
}
const getters = {
    allPermissions: state => state.allPermissions,
    permissions: state => state.permissions,
    permission: state => state.permission,
}

const actions = {
    async getPermissions({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/permission`, config)
        commit('setPermissions', response.data.data)
        return response.data
    },
    async getAllPermissions({commit}) {
        const response = await axios.get(`api/allPermission`)
        commit('setAllPermissions', response.data)
        return response.data
    },
    async createPermission({commit}, payload) {
        const response = await axios.post('api/permission', payload)
        return response.data
    },
    async showPermission({commit}, payload) {
        return commit("setPermission", payload)
    },
    async updatePermission({getters}, payload) {
        var permission = getters.permission
        const response = await axios.put(`api/permission/${permission.id}`, payload)
        return response.data
    },
    async deletePermission({commit}, payload) {
        const response = await axios.delete(`api/permission/${payload.id}`)
        if (response.data) {
            commit("deletePermission", payload)
        }
        return response.data
    }
}

const mutations = {
    setAllPermissions: (state, allPermissions) => state.allPermissions = allPermissions,
    setPermissions: (state, permissions) => state.permissions = permissions,
    setPermission: (state, permission) => state.permission = permission,
    deletePermission: (state, permission) => state.permissions = state.permissions.filter(element => (element.id !== permission.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}