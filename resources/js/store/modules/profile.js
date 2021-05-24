import axios from 'axios'

const state = {
    profile: [],
}

const getters = {
    profile: state => state.profile
}

const actions = {
    async getProfile({commit}) {
        const response = await axios.get('api/profile')
        commit("setProfile", response.data)
        return response.data
    },
    async updateProfile({getters}, payload) {
        const response = await axios.put('api/user/' + payload.id, payload)
        return response.data
    },
}

const mutations = {
    setProfile: (state, profile) => state.profile = profile
}

export default {
    state,
    getters,
    actions,
    mutations
}