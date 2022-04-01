import Vue from "vue"
import Vuex from "vuex"
import Axios from 'axios'
import product from './modules/product'
import designation from './modules/designation'
import user from './modules/user'
import category from './modules/category'
import variant from './modules/variant'
import inventory from './modules/inventory'
import ingredient from './modules/ingredient'
import role from './modules/role'
import permission from './modules/permission'
import order from './modules/order'
import cart_history from './modules/cart_history'
import dashboard from './modules/dashboard'
import ordering from './modules/ordering'
import product_component from './modules/product_component'
import consumed_stock from './modules/consumed_stock'
import authentication from './modules/authentication'
import profile from './modules/profile'
import employee from './modules/employee'
import attendance from './modules/attendance'
import payroll from './modules/payroll'
import setting from './modules/setting'

Vue.use(Vuex);
Vue.prototype.$http = Axios

export const store = new Vuex.Store({
    state: {
      products: [],
      currentProduct: 'Product List',
    },
    
    mutations: {
        setCurrentProduct(state, payload) {
            state.currentProduct = payload;
        }
    },
    actions: {},
    
    getters: {
        getCurrentProduct: state => state.currentProduct
    },

    modules: {
        product,
        designation,
        user,
        category,
        variant,
        inventory,
        ingredient,
        role,
        permission,
        order,
        cart_history,
        dashboard,
        ordering,
        product_component,
        consumed_stock,
        authentication,
        profile,
        employee,
        attendance,
        payroll,
        setting
    }

});