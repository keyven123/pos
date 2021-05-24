import axios from 'axios'

const state = {
    userAuthentication: {}
}
const getters = {
    userAuthentication: state => state.userAuthentication
}
const actions = {
    async authenticate({commit}) {
        const response = await axios.get('api/authenticate')

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