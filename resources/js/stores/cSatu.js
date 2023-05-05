import $axios from '../api.js'

const state = () => ({
    allCSatu: [],
    cSatu: {
        id_tps: '',
        foto: '',
        jml_suara: '',
    },
    page: 1,
    id: ''
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.allCSatu = payload
    },
    ASSIGN_FORM(state, payload){
        state.cSatu = {
            id_tps: payload.id_tps,
            foto: payload.foto,
            jml_suara: payload.jml_suara,
        }
    },
    CLEAR_FORM(state){
        state.cSatu = {
            id_tps: '',
            foto: '',
            jml_suara: '',
        }
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    SET_ID_UPDATE(state, payload) {
        state.id = payload
    }
}

const actions = {
    getAllCSatu({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/c1?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitCSatu({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/c1`, payload, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then((response) => {
                console.log(response)
                dispatch('getAllCSatu').then(() => {
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
    editCSatu({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/c1/${payload}/edit`)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    updateCSatu({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/c1/${state.id}`, payload, {
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
    removeCSatu({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/c1/${payload}`)
            .then((response) => {
                dispatch('getAllC1').then(() => resolve(response.data))
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