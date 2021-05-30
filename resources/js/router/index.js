import Vue from 'vue'

import VueRouter from 'vue-router'
import Dashboard from '../components/dashboard/Dashboard'
import Product from '../components/product/Product'
import Inventory from '../components/inventory/Inventory'
import Category from '../components/category/Category'
import User from '../components/management/user/User'
import Ingredients from '../components/ingredient/Ingredients'
import Role from '../components/management/role/Role'
import Permission from '../components/management/permission/Permission'
import Order from '../components/order/Order'
import SalesPOS from '../components/pos/sales/SalesPOS'
import OrdersPOS from '../components/pos/ordering/OrdersPOS'
import ProductComponent from '../components/product_component/ProductComponent'
import Profile from '../components/profile/Profile'
import Employee from '../components/employee/Employee'
import Attendance from '../components/attendance/Attendance'
import Payroll from '../components/payroll/Payroll'
import Queue from '../components/queue/Queue'
import {store} from '../store'

Vue.use(VueRouter)
let routes = [
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'Dashboard',
    },
    {
        path: '/category',
        component: Category,
        name: 'Category'
    },
    {
        path: '/product',
        component: Product,
        name: 'Product'
    },
    {
        path: '/inventory',
        component: Inventory,
        name: 'Inventory'
    },
    {
        path: '/user-management',
        component: User,
        name: 'User Management'
    },
    {
        path: '/ingredients',
        component: Ingredients,
        name: 'Ingredient'
    },
    {
        path: '/roles',
        component: Role,
        name: 'Roles'
    },
    {
        path: '/permissions',
        component: Permission,
        name: 'Permissions'
    },
    {
        path: '/order',
        component: Order,
        name: 'Order'
    },
    {
        path: '/sales-pos',
        component: SalesPOS,
        name: 'Sales POS'
    },
    {
        path: '/orders-pos',
        component: OrdersPOS,
        name: 'Orders POS'
    },
    {
        path: '/product-component',
        component: ProductComponent,
        name: 'Product Component'
    },
    {
        path: '/profile',
        component: Profile,
        name: 'Profile'
    },
    {
        path: '/employee',
        component: Employee,
        name: 'Employee'
    },
    {
        path: '/attendance',
        component: Attendance,
        name: 'Attendance'
    },
    {
        path: '/payroll',
        component: Payroll,
        name: 'Payroll'
    },
];

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

// var token = localStorage.getItem('token')
// if(token === null) {
//     router.replace('login')
// }
// store.dispatch("authenticate")
// .then(response => {
//     if (response && response.userAuthentication.designation_id == 1) {
//         router.replace('dashboard')
//     } else {
//         router.replace('sales-pos')
//     }
// })

export default router