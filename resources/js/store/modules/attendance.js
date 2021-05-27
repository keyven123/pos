import axios from 'axios'

const state = {
    attendance: {},
    table_history: []
}
const getters = {
    attendance: state => state.category,
    TableHistory: state => state.table_history,
}

const actions = {
    async getMyAttendance({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get(`api/attendance`, config)
        commit('setAttendance', response.data)
        return response.data
    },
    async getTodayAttendance() {
        const response = await axios.get('api/attendance/getTodayAttendance')
        return response.data
    },
    async getFirstAndLastRecord({commit} ,payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/attendance/getFirstAndLastRecord', config)
        return response
    },
    async getHistoryTable({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/attendance/historyTable', config)
        commit("setTableHistory", response.data.data)
        return response.data
    }
}

const mutations = {
    setAttendance: (state, attendance) => state.attendance = attendance,
    setTableHistory: (state, table_history) => state.table_history = table_history,
}

export default {
    state,
    getters,
    actions,
    mutations
}