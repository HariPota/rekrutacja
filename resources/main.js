import Vue from 'vue'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import vuetify from "./plugins/vuetify";
import VuetifyConfirm from "./plugins/confirm";
import App from './App.vue'

Vue.use(VuetifyConfirm, { vuetify })

new Vue({
    el: '#app',
    vuetify,
    render: (h) => h(App),
});
