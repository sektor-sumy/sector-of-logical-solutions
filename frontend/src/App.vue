<template>
  <div id="app">
    <router-view :lang="lang" @swLang="switchLang"/>
  </div>
</template>

<script>
export default {
  name: 'App',
  data () {
    return {
      lang: 'en'
    }
  },
  mounted: function () {
    if (this.$cookie.get('lang')) {
      this.lang = this.$cookie.get('lang')
    }
  },
  methods: {
    switchLang: function($newLang) {
      this.lang = $newLang;
      this.$cookie.set('lang', this.lang, 7);
    }
  }
}
</script>

<style>
  @import '../vendor-web/bootstrap/css/bootstrap.min.css';
</style>
