import Vue from 'vue';

import './config/bootstrap';

window.vm = new Vue({
    el: '#content',
    components: require('./components'),
});
