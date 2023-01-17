import Vue from 'vue'
import App from './App.vue'
import VModal from 'vue-js-modal';

Vue.use(VModal, { dialog: true })

Vue.config.productionTip = false
Vue.prototype.$apiUrl = 'http://localhost/trello_app/trello_laravel/public/api';
Vue.prototype.$apiToken = '3|1PVGe70WvvsbVuwwUl9EWBcRWmyLUg5XmdhKCKzq';

new Vue({
  render: h => h(App),
}).$mount('#app')
