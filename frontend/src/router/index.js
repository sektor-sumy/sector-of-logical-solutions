import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import PageContent from '@/components/PageContent'
import AboutUs from '@/components/AboutUs'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: HelloWorld
    },
    {
      path: '/about',
      component: AboutUs
    },
    {
      path: '/:slug',
      component: PageContent
    }
  ],
  watch: {
    '$route' (to, from) {
      console.log('dasd')
    }
  }
})
