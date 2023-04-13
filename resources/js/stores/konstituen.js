import $axios from '../api.js'

const state = () => ({
    konstituens: [],
    konstituen: {
        id: '',
        nik: '',
        nama: '',
        no_hp: '',
        alamat: '',
        rt: '',
        rw: '',
        desa: '',
        id_desa: '',
        kecamatan: '',
        id_kecamatan: '',
        agama: '',
        status_pernikahan: '',
        pekerjaan: '',
        foto: '',
        rekruter: '',
        id_rekruter: '',
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.konstituens = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.konstituen = {
            id: payload.id,
            nik: payload.nik,
            nama: payload.nama,
            no_hp: payload.no_hp,
            alamat: payload.alamat,
            rt: payload.rt,
            rw: payload.rw,
            desa: payload.desa,
            id_desa: payload.iid_desad,
            kecamatan: payload.kecamatan,
            id_kecamatan: payload.id_kecamatan,
            agama: payload.agama,
            status_pernikahan: payload.status_pernikahan,
            pekerjaan: payload.pekerjaan,
            foto: payload.foto,
            rekruter: payload.rekruter,
            id_rekruter: payload.id_rekruter,
        }
    },
    CLEAR_FORM(state) {
        state.konstituen = {
            id: '',
            nik: '',
            nama: '',
            no_hp: '',
            alamat: '',
            rt: '',
            rw: '',
            desa: '',
            id_desa: '',
            kecamatan: '',
            id_kecamatan: '',
            agama: '',
            status_pernikahan: '',
            pekerjaan: '',
            foto: '',
            rekruter: '',
            id_rekruter: '',
        }
    }
}

const actions = {
    getkonstituens({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/konstituens?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitkonstituen({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/konstituens`, state.konstituen)
            .then((response) => {
                dispatch('getkonstituens').then(() => {
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
    editkonstituen({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/konstituens/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updatekonstituen({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/konstituens/${payload}`, state.konstituen)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removekonstituen({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/konstituens/${payload}`)
            .then((response) => {
                dispatch('getkonstituens').then(() => resolve())
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