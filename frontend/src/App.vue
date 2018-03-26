<template>
  <div id="app">
    <page-menu/>
    <router-view/>
  </div>
</template>

<script>
import PageMenu from './components/Menu'

export default {
    components: {PageMenu},
    name: 'App'
}
</script>

<style>
@import '../vendor-veb/bootstrap/css/bootstrap.min.css';
@import '../vendor-veb/startbootstrap-creative-gh-pages/css/creative.min.css';
body {
  background: #1d5987;
}
</style>
