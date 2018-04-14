import Vue from 'vue'
import App from './App'
import router from './router'
import VueCookie from 'vue-cookie'
import axios from 'axios'
import VueScrollTo from 'vue-scrollto'

Vue.config.productionTip = false
Vue.use(VueScrollTo)
Vue.use(VueCookie)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>',
  data () {
    return {
      uploadfinfo: 0,
      slug: []
    }
  },
  watch: {
    uploadfinfo: {
      handler: function () {
        axios.get(`http://dev.logical.net/api/page`)
        .then(response => {
          for (var item in response.data) {
          this.slug.push(response.data[item].slug)
         }
        })
        .catch(e => {
          console.log('error!')
        })
      },
      immediate: true
    }
  }
})
