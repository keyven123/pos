import axios from 'axios'

const state = {
    attendance: {}
}
const getters = {
    attendance: state => state.category,
}

const actions = {
    async getMyAttendance({commit}) {
        const response = await axios.get(`api/attendance`)
        commit('setAttendance', response.data)
        return response.data
    },
    async getTodayAttendance() {
        const response = await axios.get('api/attendance/getTodayAttendance')
        return response.data
    },
}

const mutations = {
    setAttendance: (state, attendance) => state.attendance = attendance,
}

export default {
    state,
    getters,
    actions,
    mutations
}