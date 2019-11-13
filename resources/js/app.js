/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform'; //importing V-form validation
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('pagination', require('laravel-vue-pagination'));

import Multiselect from 'vue-multiselect';
Vue.component('Multiselect', require('vue-multiselect'));
window.Multiselect = Multiselect;

//Using Sweet alerts and components globally
import swal from 'sweetalert2'
window.swal = swal;

//******* Toast: *********
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
})
window.toast = toast; //adding to window

/***************************************************************/
window.Fire =  new Vue(); //using global comunication


//Using progress bar to present timeout
import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
 color: '#114e7e',
 failedColor: '#cc071e',
 height: '5px'
});


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('projects', require('./components/ProjectComponent.vue').default);
Vue.component('users', require('./components/UserComponent.vue').default);
Vue.component('profile', require('./components/ProfileComponent.vue').default);
Vue.component('catalogs', require('./components/CatalogsComponent.vue').default);
Vue.component('parameters', require('./components/ParametersComponent.vue').default);
Vue.component('subparameters', require('./components/SubParametersComponent.vue').default);
Vue.component('variables', require('./components/VariableComponent.vue').default);
Vue.component('help', require('./components/HelpComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
      search:''
    },
    methods:{
      searchit: _.debounce(() => {
            Fire.$emit('searching');
        },900),
    }
});
