import Vue from 'vue'
import Router from 'vue-router'

import Homepage from '@/components/Homepage'
import PageContent from '@/components/PageContent'
import Conversation from '@/components/Conversation'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Homepage
    },
    {
      path: '/:slug',
      component: PageContent
    },
    {
      path: '/conversation/:slug',
      component: Conversation
    }
  ]
})
