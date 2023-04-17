import $axios from '../api.js'

const state = () => ({
    konstituens: [],
    page: 1,
    id: ''
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.konstituens = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    SET_ID_UPDATE(state, payload) {
        state.id = payload
    }
}

const actions = {
    getKonstituens({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/konstituens?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitKonstituen({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/konstituens`, payload, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then((response) => {
                dispatch('getKonstituens').then(() => {
                    resolve(response.data)
                })
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    editKonstituen({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/konstituens/${payload}/edit`)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    updateKonstituen({ state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/konstituens/${state.id}`, payload, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                resolve(response.data)
            }).catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    } ,
    removeKonstituen({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/konstituens/${payload}`)
            .then((response) => {
                dispatch('getKonstituens').then(() => resolve(response.data))
            })
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}