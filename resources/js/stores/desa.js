import $axios from '../api.js'

const state = () => ({
    desas: [],
    nameDesa: [],
    desa: {
        nama: '',
        id_kecamatan: '',
        dapil: '',
        pemilih_pria: '',
        pemilih_wanita: '',
        jumlah_tps: '',
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.desas = payload
    },
    ASSIGN_NAME_DESA(state, payload) {
        state.nameDesa = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.desa = {
            nama: payload.nama,
            id_kecamatan: payload.id_kecamatan,
            dapil: payload.dapil,
            pemilih_pria: payload.pemilih_pria,
            pemilih_wanita: payload.pemilih_wanita,
            jumlah_tps: payload.jumlah_tps,
        }
    },
    CLEAR_FORM(state) {
        state.desa = {
            nama: '',
            id_kecamatan: '',
            dapil: '',
            pemilih_pria: '',
            pemilih_wanita: '',
            jumlah_tps: '',
        }
    }
}

const actions = {
    getdesas({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/desas?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    getNameDesa({ commit }){
        return new Promise((resolve, reject) => {
            $axios.get('/name-desa').then((response) => {
                commit('ASSIGN_NAME_DESA', response.data);
                resolve(response.data)
            })
        })
    },
    submitdesa({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/desas`, state.desa)
            .then((response) => {
                dispatch('getdesas').then(() => {
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
    editdesa({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/desas/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updatedesa({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/desas/${payload}`, state.desa)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removedesa({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/desas/${payload}`)
            .then((response) => {
                dispatch('getdesas').then(() => resolve())
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