require('./bootstrap');
window.Vue = require('vue');
const app  = new Vue({
    el: '#app',
    components:{
        'steps':require('./components/steps.vue').default,
        'search':require('./components/search/search.vue').default,
    }
})