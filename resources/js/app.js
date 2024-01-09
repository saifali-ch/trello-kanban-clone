import './bootstrap';
import Vue from 'vue';
import VModal from 'vue-js-modal';

import Board from "./components/Board.vue";

window.Vue = Vue;
window.Event = new Vue(); // Shared Event Handler

Vue.use(VModal);
Vue.component('board', Board);

new Vue({
    el: '#app',
});
