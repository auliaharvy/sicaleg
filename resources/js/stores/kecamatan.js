import $axios from '../api.js'

const state = () => ({
    kecamatans: [],
    kecamatan: {
        nama: '',
        dapil: '',
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.kecamatans = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.kecamatan = {
            nama: payload.nama,
            dapil: payload.dapil,
        }
    },
    CLEAR_FORM(state) {
        state.kecamatan = {
            nama: '',
            dapil: '',
        }
    }
}

const actions = {
    getKecamatans({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/kecamatans?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitKecamatan({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/kecamatans`, state.kecamatan)
            .then((response) => {
                dispatch('getKecamatans').then(() => {
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
    editKecamatan({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/kecamatans/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateKecamatan({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/kecamatans/${payload}`, state.kecamatan)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removeKecamatan({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/kecamatans/${payload}`)
            .then((response) => {
                dispatch('getKecamatans').then(() => resolve())
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