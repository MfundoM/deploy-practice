// Packages
require('./bootstrap');
require('@fortawesome/fontawesome-free');
require('sweetalert');
require('flatpickr');
require('moment');
// require('summernote');

// Custom
require('./user/custom');

// Vue Components
window.Vue = require('vue');

// Vue.component('example-component', require('./user/components/ExampleComponent.vue').default);
Vue.component('sweet-alert', require('./user/components/SweetAlert').default);

const app = new Vue({
    el: '#app',
});
