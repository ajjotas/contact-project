import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import helpers from './helpers';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'


Vue.config.productionTip = false

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueAxios, axios)
Vue.use(VueTheMask)

Vue.prototype.$h = helpers;

axios.defaults.baseURL = 'http://localhost:8000/api'

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
