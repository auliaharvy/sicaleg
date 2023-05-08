import Vue from 'vue'
import Router from 'vue-router'
import Home from './pages/Home.vue'
import HomeDua from './pages/HomeDua.vue'
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

import IndexTps from './pages/tps/Index.vue'
import DataTps from './pages/tps/Tps.vue'
import AddTps from './pages/tps/Add.vue'
import EditTps from './pages/tps/Edit.vue'

import IndexDpt from './pages/dpt/Index.vue'
import DataDpt from './pages/dpt/Dpt.vue'
import AddDpt from './pages/dpt/Add.vue'
import EditDpt from './pages/dpt/Edit.vue'

import AddCSatu from './pages/cSatu/Add.vue'
import EditCSatu from './pages/cSatu/Edit.vue'


Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: { requiresAuth: true, permissions: ['home'] }
        },
        {
            path: '/homeDua',
            name: 'home_dua',
            component: HomeDua,
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
                    meta: { requiresAuth: true, title: 'Manage Kecamatan', permissions: ['read kecamatans']},
                },
                {
                    path: 'add',
                    name: 'kecamatans.add',
                    component: AddKecamatan,
                    meta: { title: 'Add New Kecamatan', permissions: ['create kecamatans'] }
                },
                {
                    path: 'edit/:id',
                    name: 'kecamatans.edit',
                    component: EditKecamatan,
                    meta: { title: 'Edit Kecamatan', permissions: ['edit kecamatans'] }
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
                    meta: { title: 'Manage Desa', permissions: ['read desas']}
                },
                {
                    path: 'add',
                    name: 'desas.add',
                    component: AddDesa,
                    meta: { title: 'Add New Desa', permissions: ['create desas']}
                },
                {
                    path: 'edit/:id',
                    name: 'desas.edit',
                    component: EditDesa,
                    meta: { title: 'Edit Desa', permissions: ['edit desas'] }
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
                    meta: { title: 'Manage Konstituen', permissions: ['read konstituens'] }
                },
                {
                    path: 'add',
                    name: 'konstituens.add',
                    component: AddKonstituen,
                    meta: { title: 'Add New Konstituen', permissions: ['create konstituens'] }
                },
                {
                    path: 'edit/:id',
                    name: 'konstituens.edit',
                    component: EditKonstituen,
                    meta: { title: 'Edit Konstituen', permissions: ['edit konstituens'] }
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
                    meta: { title: 'Manage Outlets', permissions: ['read outlets'] }
                },
                {
                    path: 'add',
                    name: 'outlets.add',
                    component: AddOutlet,
                    meta: { title: 'Add New Outlet', permissions: ['create outlets'] }
                },
                {
                    path: 'edit/:id',
                    name: 'outlets.edit',
                    component: EditOutlet,
                    meta: { title: 'Edit Outlet', permissions: ['edit outlets'] }
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
                    meta: { title: 'Manage Couriers', permissions: ['read couriers'] }
                },
                {
                    path: 'add',
                    name: 'couriers.add',
                    component: AddCouriers,
                    meta: { title: 'Add New Couriers', permissions: ['create couriers'] }
                },
                {
                    path: 'edit/:id',
                    name: 'couriers.edit',
                    component: EditCouriers,
                    meta: { title: 'Edit Courier', permissions: ['edit couriers'] }
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
                    meta: { title: 'Manage Products', permissions: ['read products'] }
                },
                {
                    path: 'add',
                    name: 'products.add',
                    component: AddProduct,
                    meta: { title: 'Add New Product', permissions: ['create products'] }
                },
                {
                    path: 'edit/:id',
                    name: 'products.edit',
                    component: EditProduct,
                    meta: { title: 'Edit Product', permissions: ['edit products'] }
                },
            ]
        },
        {
            path: '/setting',
            component: Setting,
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'role-permission',
                    name: 'role.permissions',
                    component: SetPermission,
                    meta: {title: 'Set Permissions', permissions: ['read seting role permission']}
                }
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
                    meta: { title: 'Manage Expenses', permissions: ['read expenses'] }
                },
                {
                    path: 'add',
                    name: 'expenses.create',
                    component: CreateExpenses,
                    meta: { title: 'Add New Expenses', permissions: ['create expenses'] }
                },
                {
                    path: 'edit/:id',
                    name: 'expenses.edit',
                    component: EditExpenses,
                    meta: { title: 'Edit Expenses', permissions: ['edit expenses'] }
                },
                {
                    path: 'view/:id',
                    name: 'expenses.view',
                    component: ViewExpenses,
                    meta: { title: 'View Expenses', permissions: ['view expenses'] }
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
                    meta: { title: 'Manage Customers', permissions: ['read customers'] }
                },
                {
                    path: 'add',
                    name: 'customers.add',
                    component: AddCustomer,
                    meta: { title: 'Add New Customers', permissions: ['create customers'] }
                },
                {
                    path: 'edit/:id',
                    name: 'customers.edit',
                    component: EditCustomer,
                    meta: { title: 'Edit Customer', permissions: ['edit customers'] }
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
                    meta: { title: 'Create New Transaction', permissions: ['read transactions'] }
                },
                {
                    path: 'view/:id',
                    name: 'transactions.view',
                    component: ViewTransaction,
                    meta: { title: 'View Transaction', permissions: ['edit transactions'] }
                },
                {
                    path: 'list',
                    name: 'transactions.list',
                    component: ListTransaction,
                    meta: { title: 'List Transaction', permissions: ['list transactions']}
                },
            ]
        },
        {
            path: '/tps',
            component: IndexTps,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'tps.data',
                    component: DataTps,
                    meta: { title: 'Manage Tps', permissions: ['read tps'] }
                },
                {
                    path: 'add',
                    name: 'tps.add',
                    component: AddTps,
                    meta: { title: 'Add New Tps', permissions: ['create tps'] }
                },
                {
                    path: 'edit/:id',
                    name: 'tps.edit',
                    component: EditTps,
                    meta: { title: 'Edit Tps', permissions: ['edit tps'] }
                },
                {
                    path: 'c1/add/:id',
                    name: 'tps.cSatu.add',
                    component: AddCSatu,
                    meta: { title: 'Add C Satu', permissions: ['create c satu tps'] }
                },
                {
                    path: 'c1/edit/:id',
                    name: 'tps.cSatu.edit',
                    component: EditCSatu,
                    meta: { title: 'Edit C Satu', permissions: ['edit c satu tps'] }
                },
            ]
        },
        {
            path: '/dpt',
            component: IndexDpt,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'dpt.data',
                    component: DataDpt,
                    meta: { title: 'Manage Dpt', permissions: ['read dpt'] }
                },
                {
                    path: 'add',
                    name: 'dpt.add',
                    component: AddDpt,
                    meta: { title: 'Add New Dpt', permissions: ['create dpt'] }
                },
                {
                    path: 'edit/:id',
                    name: 'dpt.edit',
                    component: EditDpt,
                    meta: { title: 'Edit Dpt', permissions: ['edit dpt'] }
                },
            ]
        },
 
    ]
});

router.beforeEach(async(to, from, next) => {
    store.commit('CLEAR_ERRORS')
    if (to.matched.some(record => record.meta.requiresAuth)) {
        let auth = store.getters.isAuth
        if (!auth) {
            next({ name: 'login' })
        } else {
            if(localStorage.getItem('permission').includes(to.meta.permissions) || to.meta.permissions[0] == 'home'){
                next()
            }else{
                router.push({name: 'home'})
            }
        }
    }else {
        next()
    }
})

export default router
