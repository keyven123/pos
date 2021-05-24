import axios from 'axios'

const state = {
    designations: [],
    designation: {}
}
const getters = {
    allDesignations: state => state.designations,
    designation: state => state.designation,
}

const actions = {
    async getAllDesignations({commit}) {
        const response = await axios.get('api/designation')

        commit('setDesignations', response.data)
        return response.data
    }
}

const mutations = {
    setDesignations: (state, designations) => state.designations = designations,
}

export default {
    state,
    getters,
    actions,
    mutations
}