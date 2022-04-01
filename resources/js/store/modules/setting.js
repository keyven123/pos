import axios from 'axios'
import { defaultsDeep } from 'lodash'

const state = {
    settings: [],
}

const getters = {
    settings: state => state.settings
}

const actions = {
    async getSetting({commit}) {
        const response = await axios.get('api/setting')
        commit("setSetting", response.data)
        return response.data
    },

    async updateSetting({getters}, payload) {
        console.log(payload);
        const response = await axios.put('api/setting/' + payload.id, payload)
        return response.data
    },

    async uploadImage({getters}, payload) {
        const response = await axios.post('api/setting', payload)
        return response.data
    }
}

const mutations = {
    setSetting: (state, settings) => state.settings = settings
}

export default {
    state,
    getters,
    actions,
    mutations
}