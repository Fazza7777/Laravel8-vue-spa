
require('./bootstrap');
import { Form, HasError, AlertError } from 'vform'
import Swal from 'sweetalert2'
import Vue from 'vue';
import Loading from 'vue-loading-overlay';

Vue.use(Loading,{loader:'Dots',color:'blue'});
window.Vue = require('vue');
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('product-component', require('./components/ProductComponent.vue').default);


import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
   height: '2px',
  thickness:'10px'
})

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

window.Form = Form;
window.Swal = Swal
const app = new Vue({
    el: '#app',
});
