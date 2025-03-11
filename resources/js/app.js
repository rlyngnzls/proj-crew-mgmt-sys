/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';


require('./bootstrap');

window.$ = window.jQuery = require('jquery');
require('popper.js');
require('bootstrap');

window.Vue = require('vue').default;

Vue.use(VueSweetalert2);
Vue.use(BootstrapVue);

Vue.prototype.$search_data = null;
Vue.prototype.$page_options = [
    { value: 'All', text: 'All' },
    { value: '5', text: '5' },
    { value: '10', text: '10' },
    { value: '50', text: '50' },
    { value: '100', text: '100' },
];

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Crew List
Vue.component('crew-list-component', require('./components/CrewListComponent.vue').default);

// Crew Documents
Vue.component('crew-documents-component', require('./components/CrewDocumentsComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
