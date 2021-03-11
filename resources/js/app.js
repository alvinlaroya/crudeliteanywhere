require("./bootstrap");

import Vue from "vue";
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
Vue.use(Vuetify)
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);
import store from './store/index'
import App from "./vue/app.vue";

const app = new Vue({
    el: "#app",
    store,
    vuetify: new Vuetify(),
    components: { App },
});
 
/* app = new Vue({
     router,
    vuetify,
    render: (h) => h(App),
    store: store
}).$mount("#app");
 */