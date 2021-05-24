import axios from 'axios'

const state = {
    ingredients: [],
    ingredient: {}
}
const getters = {
    allIngredients: state => state.ingredients,
    ingredient: state => state.ingredient,
}

const actions = {
    async getAllIngredients({commit}, payload = {}) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/ingredient`, config)
        commit('setIngredients', response.data.data)
        return response.data
    },
    async createIngredient({commit}, payload) {
        const response = await axios.post('api/ingredient', payload)
        return response.data
    },
    async showIngredient({commit}, payload) {
        return commit("setIngredient", payload)
    },
    async updateIngredient({getters}, payload) {
        var ingredient = getters.ingredient
        const response = await axios.put(`api/ingredient/${ingredient.id}`, payload)
        return response.data
    },
    async deleteIngredient({commit}, payload) {
        const response = await axios.delete(`api/ingredient/${payload.id}`)
        if (response.data) {
            commit("deleteIngredient", payload)
        }
        return response.data
    }
}

const mutations = {
    setIngredients: (state, ingredients) => state.ingredients = ingredients,
    setIngredient: (state, ingredient) => state.ingredient = ingredient,
    deleteIngredient: (state, ingredient) => state.ingredients = state.ingredients.filter(element => (element.id !== ingredient.id))
}

export default {
    state,
    getters,
    actions,
    mutations
}