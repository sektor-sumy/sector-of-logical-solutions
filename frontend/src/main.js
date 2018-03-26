// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>',
  data () {
    return {
      uploadfinfo: 0,
      slug: [],
      slugpage: 0
    }
  },
  watch: {
    uploadfinfo: {
      handler: function () {
        axios.get(`http://dev.logical.net/api/page`)
        .then(response => {
          for (var item in response.data){
          this.slug.push(response.data[item].slug)
         }
        })
        .catch(e => {
          console.log('error!')
        })
        axios.get(`http://dev.logical.net/api/page` + this.$route.path)
        .then(response => {
          this.slugpage = response.data
        })
      },
      immediate: true
    }
  }
})
