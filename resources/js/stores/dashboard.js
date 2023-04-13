import $axios from '../api.js'

const state = () => ({
    transactions: [],
    desas: [],
})

const mutations = {
    ASSIGN_DATA_TRANSACTION(state, payload) {
        state.transactions = payload
    },
    ASSIGN_DATA_DESA(state, payload) {
        state.desas = payload
    }
}

const actions = {
    getChartData({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/chart?month=${payload.month}&year=${payload.year}`)
            .then((response) => {
                commit('ASSIGN_DATA_TRANSACTION', response.data)
                resolve(response.data)
            })
        })
    },
    getChartDataDesa({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/chart-desa`)
            .then((response) => {
                commit('ASSIGN_DATA_DESA', response.data)
                resolve(response.data)
            })
        })
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}