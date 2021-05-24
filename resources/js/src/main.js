import Vue from 'vue'
import router from '../router'
import Vuetify from 'vuetify'
import { store } from '../store';
Vue.use(Vuetify);

import Swal from 'sweetalert2'
window.Swal = Swal;

import 'vuetify/dist/vuetify.min.css'
window.Vue = require('vue').default;

Vue.filter("currency", function(value){
    let val = (value/1).toFixed(2).replace('.', '.')
    return "₱" + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
});

Vue.filter("unit", function(value){
    let val = (value/1).toFixed(2).replace('.', '.')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
});

// moment.js
var moment = require('moment');
window.moment = moment
Vue.filter("myDate", function(created) {
    return moment(created).format("MMMM DD YYYY");
});
Vue.filter("completeDate", function(created) {
    return moment(created).format("MMMM DD YYYY, h:mm a");
});

import VueGoogleCharts from 'vue-google-charts'
Vue.use(VueGoogleCharts)

const app = new Vue({
    store,
    router,
    el: '#app',
    vuetify: new Vuetify(),
    mode: 'history'
});
