<template>
  <div>
    {{ msg }}
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'homepage',
  data () {
    return {
      msg: 'Главная',
      content: {},
      contentload: 0
    }
  },
  mounted: function () {
    axios.get(`http://dev.logical.net/api/page?homepage=true`)
      .then(response => {
      this.content = response.data
      document.title = this.content.title
    })
  }
}
</script>

<style scoped>

</style>
