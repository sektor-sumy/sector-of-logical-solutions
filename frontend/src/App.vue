<template>
  <div id="app">
    <page-menu/>
    <div class="container">
      <div class="row">
      <router-view/>
      <page-widget/>
      </div>
    </div>
    <page-footer/>
  </div>
</template>

<script>
import PageMenu from './components/Page/PageMenu'
import PageFooter from './components/Page/PageFooter'
import PageWidget from './components/Page/PageWidget'

export default {
  name: 'App',
  components: {
    PageMenu: PageMenu,
    PageFooter: PageFooter,
    PageWidget: PageWidget
  }
}
</script>

<style>
@import '../vendor-veb/bootstrap/css/bootstrap.min.css';
@import '../vendor-veb/startbootstrap-creative-gh-pages/css/creative.min.css';
@import '../vendor-veb/startbootstrap-blog-post/css/blog-post.css';
</style>
