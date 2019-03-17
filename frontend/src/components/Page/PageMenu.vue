<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">SoLS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">

                    <li v-for="item in menu" v-bind:key="item">
                        <a class="nav-link" v-bind:href="'/'+item.slug">{{ item.title }}</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from 'axios'
export default {
  name: 'page-menu',
  data () {
    return {
      menu: [],
      loadmenu: 0
    }
  },
  watch: {
    loadmenu: {
      handler: function () {
        axios.get(`${this.$root.host}/api/pagemenu`)
          .then(response => {
            this.menu = response.data
          })
      },
      immediate: true
    }
  }
}
</script>

<style>
    body {
        padding-top: 54px;
    }

    @media (min-width: 992px) {
        body {
            padding-top: 56px;
        }
    }
</style>
