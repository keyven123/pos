import axios from 'axios'

const state = {
    attendance: {},
    attendances: [],
    table_history: [],
    summary: {}
}
const getters = {
    attendance: state => state.attendance,
    attendances: state => state.attendances,
    TableHistory: state => state.table_history,
    summary: state => state.summary
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
    async filterAttendances({commit} ,payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/attendance/filterAttendances', config)
        commit('setAttendances', response.data.data)
        return response.data
    },
    async getTodayAttendance({commit},payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/attendance/getTodayAttendance', config)
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
    },
    async createTimeIn({commit}, payload) {
        const response = await axios.post('api/attendance', payload)
        return response.data
    },
    async getAttendanceSummary({commit}, payload) {
        var config = {
            params: payload
        }
        const response = await axios.get('api/attendance/getAttendanceSummary', config)
        commit("setSummary", response.data)
        return response.data
    }
}

const mutations = {
    setAttendance: (state, attendance) => state.attendance = attendance,
    setAttendances: (state, attendances) => state.attendances = attendances,
    setTableHistory: (state, table_history) => state.table_history = table_history,
    setSummary: (state, summary) => state.summary = summary,
}

export default {
    state,
    getters,
    actions,
    mutations
}