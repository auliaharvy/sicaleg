import $axios from '../api.js'

const state = () => ({
    allDpt: [],
    dpt: {
        id_tps: '',
        nik: '',
        nama: '',
        jenis_kelamin: '',
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.allDpt = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.dpt = {
            id_tps: payload.id_tps,
            nik: payload.nik,
            nama: payload.nama,
            jenis_kelamin: payload.jenis_kelamin
        }
    },
    CLEAR_FORM(state) {
        state.dpt = {
            id_tps: '',
            nik: '',
            name: '',
            jenis_kelamin: '' 
       }
    }
}

const actions = {
    getAllDpt({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/dpt?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitDpt({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/dpt`, state.dpt)
            .then((response) => {
                dispatch('getAllDpt').then(() => {
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
    editDpt({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/dpt/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                console.log(response.data.data)
                resolve(response.data)
            })
        })
    },
    updateDpt({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            console.log(payload)
            $axios.put(`/dpt/${payload}`, state.dpt)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    }, 
    removeDpt({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/dpt/${payload}`)
            .then((response) => {
                dispatch('getAllDpt').then(() => resolve())
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