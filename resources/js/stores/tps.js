import $axios from "../api"

const state = () => ({
    allTps: [],
    tps: {
        desa_id: '',
        no_tps: '',
    },
    chart: [],
    page: 1,
})

const mutations = {
    ASSIGN_DATA(state, payload){
        state.allTps = payload 
    },
    ASSIGN_FORM(state, payload){
        state.tps = {
            desa_id: payload.desa_id, 
            no_tps: payload.no_tps,
        }
    },
    ASSIGN_CHART(state, payload){
        state.chart = payload
    },
    CLEAR_FORM(state){
        state.tps = {
            desa_id: '',
            no_tps: '',
        }
    },
    SET_PAGE(state, payload){
        state.page = payload 
    }
}

const actions = {
    getAllTps({state, commit}, payload){
        let search = typeof payload != 'undefined' ? payload : ''
        return new Promise((resolve, reject) => {
            $axios.get(`/tps?page=${state.page}&q=${search}`).then((response) => {
                commit("ASSIGN_DATA", response.data)
                resolve(response.data)
            })
        })
    },
    submitTps({commit, dispatch, state}){
        return new Promise((resolve, reject) => {
            $axios.post('/tps', state.tps).then((response) => {
                console.log(state.tps)
                dispatch('getAllTps').then(() => {
                    resolve(response.data)
                })
            }).catch((error) => {
                if(error.response.status == 422){
                    commit('SET_ERRORS', error.response.data.errors, {root: true})
                }
            })
        })
    },
    editTps({commit}, payload){
        return new Promise((resolve, reject) => {
            $axios.get(`/tps/${payload}/edit`).then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateTps({state, commit}, payload){
        return new Promise((resolve, reject) => {
            $axios.put(`/tps/${payload}`, state.tps).then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            }).catch((error) => {
                if(error.response.status == 422){
                    commit('SET_ERRORS', error.response.data.errors, {root: true});
                }
            })
        })
    },
    removeTps({dispatch}, payload){
        return new Promise((resolve, reject) => {
            $axios.delete(`/tps/${payload}`).then((response) => {
                dispatch('getAllTps').then(() => resolve())
            })
        })
    },
    getChartTps({commit, state}, payload){
        return new Promise((resolve, reject) => {
            $axios.get(`/tps/${payload}/edit/chart`).then((response) => {
                // console.log(response.data.data)
                commit('ASSIGN_CHART', response.data.data)
                console.log('dibawahi ini data chart')
                console.log(state.chart)
                resolve(response.data)
            })
        })
    }
}

export default{
    namespaced: true,
    state,
    mutations,
    actions
}