import axios from 'axios'

const state = {
    variants: [],
    variant: {}
}
const getters = {
    allVariants: state => state.variants,
    variant: state => state.variant
}
const actions = {
    async getAllVariants({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/variant`, config)
        commit('setVariants', response.data)
        return response.data
    },
    async createVariants({commit}, payload = {}) {
        const response = await axios.post('api/createVariants', payload)
        return response.data
    },
    async createVariant({commit}, payload = {}) {
        const response = await axios.post('api/variant', payload)
        // commit('newVariant', response.data.data)
        return response.data
    },
    async showVariant({commit}, payload) {
        return commit('setVariant', payload)
    },
    async updateVariant({getters}, payload) {
        var variant = getters.variant
        const response = await axios.put('api/variant/' + variant.id, payload)
        return response.data
    },
    async deleteVariant({commit}, payload) {
        const response = await axios.delete(`api/variant/${payload.id}`)
        if (response.data) {
            commit("deleteVariant", payload)
        }
        return response.data
    }
}
const mutations = {
    setVariant: (state, variant) => state.variant = variant,
    setVariants: (state, variants) => state.variants = variants,
    deleteVariant: (state, variant) => state.variants = state.variants.filter(element => (element.id !== variant.id))
    // newVariant: (state, variant) => state.variants.push(variant)
}

export default {
    state,
    getters,
    actions,
    mutations
}