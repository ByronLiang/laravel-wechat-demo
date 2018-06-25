import Vue from 'vue';
import App from './App.vue';
import * as bootstrap from './config/bootstrap';

window.vm = new Vue({
    ...App,
    ...bootstrap,
}).$mount('#app');
