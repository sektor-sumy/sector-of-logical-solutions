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
  data () {
    return {
      slug: {},
      page: {},
      upLoadPage: 1,
      lg: 0
    }
  },
  router,
  components: { App },
  template: '<App/>',
  watch: {
    upLoadPage: {
      handler: function () {
        this.getPage()
        this.getSlug()
      },
      immediate: true
    }
  },
  methods: {
    getPage : function () {
      axios.get(`http://dev.logical.net/api/page`)
        .then(response => {
        this.page = response.data
      })
      console.log('page!')
    },
    getSlug : function () {
      var addSlug = [];
      this.lp = this.page;
      for (var key = 0; key < this.page; key++) {
        addSlug.push({
          'path': this.page[key].slug,
          'component': 'default'
        })
      }
      this.slug = addSlug
      this.$router.addRoutes(addSlug)
      console.log('slug!')
    }
  }
})
