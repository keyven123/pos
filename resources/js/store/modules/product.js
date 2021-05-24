import axios from 'axios'

const state = {
    products: [],
    product: {},
}

const getters = {
    allProducts: state => state.products,
    product: state => state.product
}

const actions = {
    async getfilterCategory({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/filterCategory`, config);

        commit('setProducts', response.data)
        return response.data
    },
    async getAllProducts({ commit }, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/product`, config);

        commit('setProducts', response.data.data)
        return response.data
    },
    async createProduct({commit}, payload) {
        const response = await axios.post('api/product', payload)

        return response.data
        // commit('newProduct', response.data)
    },
    async showProduct({commit}, payload) {
        return commit('setProduct', payload)
    },

    async updateProduct({getters}, payload) {
        var product = getters.product
        const response = await axios.put('api/product/' + product.id, payload)
        return response.data
    },
    async deleteProduct({commit}, payload ) {
        const response = await axios.delete(`api/product/${payload.id}`)
        if(response.data) {
            commit('deleteProduct', payload)
        }
        return response.data
    }
    
}
const mutations = {
    setProducts: (state, products) => state.products = products,
    setProduct: (state, product) => state.product = product,
    deleteProduct: (state, product) => state.products = state.products.filter(element => (element.id !== product.id))
    // newProduct: (statem, product) => state.todos.unshift(todo)
}
export default {
    state,
    actions,
    mutations,
    getters
}