import Vue from 'vue'
import Vuex from 'vuex'

import auth from './stores/auth.js'
import outlet from './stores/outlet.js'
import courier from './stores/courier.js'
import product from './stores/product.js'
import user from './stores/user.js'
import expenses from './stores/expenses.js'
import notification from './stores/notification.js'
import customer from './stores/customer.js'
import transaction from './stores/transaction.js'
import dashboard from './stores/dashboard.js'

import kecamatan from './stores/kecamatan.js'
import desa from './stores/desa.js'
import konstituen from './stores/konstituen.js'
import tps from './stores/tps.js'
import dpt from './stores/dpt.js'
import cSatu from './stores/cSatu.js'
import dashboard_dua from './stores/dashboard_dua.js'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        auth,
        outlet,
        courier,
        product,
        user,
        expenses,
        notification,
        customer,
        transaction,
        dashboard,
        kecamatan,
        desa,
        konstituen,
        tps,
        dpt,
        cSatu,
        dashboard_dua
    },
    state: {
        token: localStorage.getItem('token'),
        errors: []
    },
    getters: {
        isAuth: state => {
            return state.token != "null" && state.token != null
        }
    },
    mutations: {
        SET_TOKEN(state, payload) {
            state.token = payload
        },
        SET_ERRORS(state, payload) {
            state.errors = payload
        },
        CLEAR_ERRORS(state) {
            state.errors = []
        }
    }
})

export default store