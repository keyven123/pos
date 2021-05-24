import axios from 'axios'

const state = {
    categories: [],
    category: {}
}
const getters = {
    allCategories: state => state.categories,
    category: state => state.category,
}

const actions = {
    async getAllCategories({commit}, payload = {}) {
        var config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            params: payload
        }

        const response = await axios.get(`api/category`, config)
        commit('setCategories', response.data.data)
        return response.data
    },
    async createCategory({commit}, payload) {
        const response = await axios.post('api/category', payload)
        return response.data
    },
    async showCategory({commit}, payload) {
        return commit("setCategory", payload)
    },
    async updateCategory({getters}, payload) {
        var category = getters.category
        const response = await axios.put(`api/category/${category.id}`, payload)
        return response.data
    },
    async deleteCategory({commit}, payload) {
        const response = await axios.delete(`api/category/${payload.id}`)
        if (response.data) {
            commit("deleteCategory", payload)
        }
        return response.data
    }
}

const mutations = {
    setCategories: (state, categories) => state.categories = categories,
    setCategory: (state, category) => state.category = category,
    deleteCategory: (state, category) => state.categories = state.categories.filter(element => (element.id !== category.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}