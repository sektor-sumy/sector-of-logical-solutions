import Vue from 'vue'
import Router from 'vue-router'
import Homepage from '@/components/Homepage'
import PageContent from '@/components/PageContent'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: PageContent
    },
    {
      path: '/:slug',
      component: PageContent
    }
  ]
})
