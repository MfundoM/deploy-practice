// Packages
require('./bootstrap');
require('@fortawesome/fontawesome-free');
require('sweetalert');
// require('flatpickr');
// require('moment');

// Custom
require('./guest/custom');

// Vue Components
window.Vue = require('vue');

// Vue.component('example-component', require('./guest/components/ExampleComponent.vue').default);
Vue.component('sweet-alert', require('./guest/components/SweetAlert').default);

const app = new Vue({
    el: '#app',
});
