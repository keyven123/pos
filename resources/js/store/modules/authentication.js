import axios from 'axios'

const state = {
    userAuthentication: {}
}
const getters = {
    userAuthentication: state => state.userAuthentication
}
const actions = {
    async authenticate({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/authenticate', config)

        var userAuthentication = response.data

        if(!userAuthentication) {
            return false
        }
        
        commit('setAuthorization', userAuthentication)
        
        return {
            userAuthentication
        }
    },
}
const mutations = {
    setAuthorization: (state,userAuthentication) => state.userAuthentication = userAuthentication
}

export default {
    state,
    getters,
    actions,
    mutations
}