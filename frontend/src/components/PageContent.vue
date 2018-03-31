<template>
    <div class="col-lg-8">
        <h1 class="mt-4">{{ content.title }}</h1>
        <p class="lead">
            by
            <a href="#">Start Bootstrap</a>
        </p>

        <hr>
        <p>Posted on {{ content.created_at }}</p>

        <hr>

        <div>{{ content.content }}</div>

    </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'page-content',
  data () {
    return {
      content: {}
    }
  },
  watch: {
    pagecontent: {
      handler: function () {
        if (this.$route.path == '/') {
          axios.get(`http://dev.logical.net/api/page?homepage=true`)
            .then(response => {
            this.content = response.data
            document.title = this.content.title
          })
        } else {
          axios.get(`http://dev.logical.net/api/page` + this.$route.path)
            .then(response => {
            this.content = response.data
            document.title = this.content.title
          })
        }
      },
      immediate: true
    }
  }
}
</script>

<style scoped>

</style>
