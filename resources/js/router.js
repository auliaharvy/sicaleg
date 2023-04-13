import Vue from 'vue'
import Router from 'vue-router'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import store from './store.js'

import IndexKecamatan from './pages/kecamatan/Index.vue'
import DataKecamatan from './pages/kecamatan/Kecamatan.vue'
import AddKecamatan from './pages/kecamatan/Add.vue'
import EditKecamatan from './pages/kecamatan/Edit.vue'

import IndexDesa from './pages/desa/Index.vue'
import DataDesa from './pages/desa/desa.vue'
import AddDesa from './pages/desa/Add.vue'
import EditDesa from './pages/desa/Edit.vue'

import IndexKonstituen from './pages/konstituen/Index.vue'
import DataKonstituen from './pages/konstituen/konstituen.vue'
import AddKonstituen from './pages/konstituen/Add.vue'
import EditKonstituen from './pages/konstituen/Edit.vue'

import IndexOutlet from './pages/outlets/Index.vue'
import DataOutlet from './pages/outlets/Outlet.vue'
import AddOutlet from './pages/outlets/Add.vue'
import EditOutlet from './pages/outlets/Edit.vue'

import IndexCourier from './pages/couriers/Index.vue'
import DataCouriers from './pages/couriers/Courier.vue'
import AddCouriers from './pages/couriers/Add.vue'
import EditCouriers from './pages/couriers/Edit.vue'

import IndexProduct from './pages/products/Index.vue'
import DataProduct from './pages/products/Product.vue'
import AddProduct from './pages/products/Add.vue'
import EditProduct from './pages/products/Edit.vue'

import Setting from './pages/setting/Index.vue'
import SetPermission from './pages/setting/roles/SetPermission.vue'

import IndexExpenses from './pages/expenses/Index.vue'
import DataExpenses from './pages/expenses/Expenses.vue'
import CreateExpenses from './pages/expenses/Add.vue'
import EditExpenses from './pages/expenses/Edit.vue'
import ViewExpenses from './pages/expenses/View.vue'

import IndexCustomer from './pages/customers/Index.vue'
import DataCustomer from './pages/customers/Customer.vue'
import AddCustomer from './pages/customers/Add.vue'
import EditCustomer from './pages/customers/Edit.vue'

import IndexTransaction from './pages/transaction/Index.vue'
import AddTransaction from './pages/transaction/Add.vue'
import ViewTransaction from './pages/transaction/View.vue'
import ListTransaction from './pages/transaction/List.vue'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: { requiresAuth: true }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/kecamatans',
            component: IndexKecamatan,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'kecamatans.data',
                    component: DataKecamatan,
                    meta: { title: 'Manage Kecamatan' }
                },
                {
                    path: 'add',
                    name: 'kecamatans.add',
                    component: AddKecamatan,
                    meta: { title: 'Add New Kecamatan' }
                },
                {
                    path: 'edit/:id',
                    name: 'kecamatans.edit',
                    component: EditKecamatan,
                    meta: { title: 'Edit Kecamatan' }
                }
            ]
        }, 
        {
            path: '/desas',
            component: IndexDesa,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'desas.data',
                    component: DataDesa,
                    meta: { title: 'Manage Desa' }
                },
                {
                    path: 'add',
                    name: 'desas.add',
                    component: AddDesa,
                    meta: { title: 'Add New Desa' }
                },
                {
                    path: 'edit/:id',
                    name: 'desas.edit',
                    component: EditDesa,
                    meta: { title: 'Edit Desa' }
                }
            ]
        },
        {
            path: '/konstituens',
            component: IndexKonstituen,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'konstituens.data',
                    component: DataKonstituen,
                    meta: { title: 'Manage Konstituen' }
                },
                {
                    path: 'add',
                    name: 'konstituens.add',
                    component: AddKonstituen,
                    meta: { title: 'Add New Konstituen' }
                },
                {
                    path: 'edit/:id',
                    name: 'konstituens.edit',
                    component: EditKonstituen,
                    meta: { title: 'Edit Konstituen' }
                }
            ]
        },
        {
            path: '/outlets',
            component: IndexOutlet,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'outlets.data',
                    component: DataOutlet,
                    meta: { title: 'Manage Outlets' }
                },
                {
                    path: 'add',
                    name: 'outlets.add',
                    component: AddOutlet,
                    meta: { title: 'Add New Outlet' }
                },
                {
                    path: 'edit/:id',
                    name: 'outlets.edit',
                    component: EditOutlet,
                    meta: { title: 'Edit Outlet' }
                }
            ]
        }, 
        {
            path: '/couriers',
            component: IndexCourier,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'couriers.data',
                    component: DataCouriers,
                    meta: { title: 'Manage Couriers' }
                },
                {
                    path: 'add',
                    name: 'couriers.add',
                    component: AddCouriers,
                    meta: { title: 'Add New Couriers' }
                },
                {
                    path: 'edit/:id',
                    name: 'couriers.edit',
                    component: EditCouriers,
                    meta: { title: 'Edit Courier' }
                },
            ]
        },
        {
            path: '/product',
            component: IndexProduct,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'products.data',
                    component: DataProduct,
                    meta: { title: 'Manage Products' }
                },
                {
                    path: 'add',
                    name: 'products.add',
                    component: AddProduct,
                    meta: { title: 'Add New Product' }
                },
                {
                    path: 'edit/:id',
                    name: 'products.edit',
                    component: EditProduct,
                    meta: { title: 'Edit Product' }
                },
            ]
        },
        {
            path: '/setting',
            component: Setting,
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'role-permission',
                    name: 'role.permissions',
                    component: SetPermission,
                    meta: { title: 'Set Permissions' }
                },
            ]
        },
        {
            path: '/expenses',
            component: IndexExpenses,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'expenses.data',
                    component: DataExpenses,
                    meta: { title: 'Manage Expenses' }
                },
                {
                    path: 'add',
                    name: 'expenses.create',
                    component: CreateExpenses,
                    meta: { title: 'Add New Expenses' }
                },
                {
                    path: 'edit/:id',
                    name: 'expenses.edit',
                    component: EditExpenses,
                    meta: { title: 'Edit Expenses' }
                },
                {
                    path: 'view/:id',
                    name: 'expenses.view',
                    component: ViewExpenses,
                    meta: { title: 'View Expenses' }
                },
            ]
        },
        {
            path: '/customers',
            component: IndexCustomer,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'customers.data',
                    component: DataCustomer,
                    meta: { title: 'Manage Customers' }
                },
                {
                    path: 'add',
                    name: 'customers.add',
                    component: AddCustomer,
                    meta: { title: 'Add New Customers' }
                },
                {
                    path: 'edit/:id',
                    name: 'customers.edit',
                    component: EditCustomer,
                    meta: { title: 'Edit Customer' }
                },
            ]
        },
        {
            path: '/transactions',
            component: IndexTransaction,
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'create',
                    name: 'transactions.add',
                    component: AddTransaction,
                    meta: { title: 'Create New Transaction' }
                },
                {
                    path: 'view/:id',
                    name: 'transactions.view',
                    component: ViewTransaction,
                    meta: { title: 'View Transaction' }
                },
                {
                    path: 'list',
                    name: 'transactions.list',
                    component: ListTransaction,
                    meta: { title: 'List Transaction' }
                },
            ]
        }
    ]
});

router.beforeEach((to, from, next) => {
    store.commit('CLEAR_ERRORS')
    if (to.matched.some(record => record.meta.requiresAuth)) {
        let auth = store.getters.isAuth
        if (!auth) {
            next({ name: 'login' })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router
