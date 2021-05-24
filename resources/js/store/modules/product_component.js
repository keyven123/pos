import axios from 'axios'

const state = {
    product_components: [],
    product_component: {}
}
const getters = {
    allProductComponents: state => state.product_components,
    product_component: state => state.product_component,
}

const actions = {
    async getAllProductComponents({commit}, payload = {}) {
        var config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            params: payload
        }

        const response = await axios.get(`api/product-component`, config)
        commit('setProductComponents', response.data.data)
        return response.data
    },
    async createProductComponent({commit}, payload) {
        const response = await axios.post('api/product-component', payload)
        return response.data
    },
    async showProductComponent({commit}, payload) {
        return commit("setProductComponent", payload)
    },
    async updateProductComponent({getters}, payload) {
        var product_component = getters.product_component
        console.log(product_component)
        const response = await axios.put(`api/product-component/${product_component.id}`, payload)
        return response.data
    },
    async updateComponentIndividual({commit}, payload) {
        const response = await axios.put(`api/updateComponentIndividual/${payload.id}`, payload)
        return response.data
    },
    async deleteProductComponent({commit}, payload) {
        const response = await axios.delete(`api/product-component/${payload.id}`)
        if (response.data) {
            commit("deleteProductComponent", payload)
        }
        return response.data
    }
}

const mutations = {
    setProductComponents: (state, product_components) => state.product_components = product_components,
    setProductComponent: (state, product_component) => state.product_component = product_component,
    deleteProductComponent: (state, product_component) => state.product_components = state.product_components.filter(element => (element.id !== product_component.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}