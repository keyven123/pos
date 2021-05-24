import axios from 'axios'

const state = {
    users: [],
    user: {}
}
const getters = {
    allUsers: state => state.users,
    user: state => state.user,
}

const actions = {
    async getAllUsers({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/user', config)

        commit('setUsers', response.data.data)
        return response.data
    },
    async createUser({commit}, payload) {
        const response = await axios.post('api/user', payload)
        return response.data
    },
    async showUser({commit}, payload) {
        return commit('setUser', payload)
    },
    async updateUser({getters}, payload) {
        var user = getters.user
        const response = await axios.put('api/user/' + user.id, payload)
        return response.data
    },
    async deleteUser({commit}, payload) {
        const response = await axios.delete(`api/user/${payload.id}`)
        if (response.data) {
            commit("deleteUser", payload)
        }
        return response.data
    }
}

const mutations = {
    setUsers: (state, users) => state.users = users,
    setUser: (state, user) => state.user = user,
    deleteUser: (state, user) => state.users = state.users.filter(element => (element.id !== user.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}