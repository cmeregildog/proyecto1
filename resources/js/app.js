require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('nombres', require('./components/NombresComponent.vue').default);
Vue.component('instituciones', require('./components/InstitucionesComponent.vue').default);
Vue.component('cursos', require('./components/CursosComponent.vue').default);

const app = new Vue({
    el: '#app',
});
