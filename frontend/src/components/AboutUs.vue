<template>
  <div>
      FAFASF {{ msg }}
      <br>
      <button @click="getPage1">rbrk</button>
      <br>
      <span>{{page}}</span>
      <button @click="getPage">rbrk {{ upLoadPage }}</button>

  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'AboutUs',
  data () {
    return {
      msg: 'gterfgsdgsd'
    }
  },
  methods: {
    getPage1: function () {
      this.msg = 'nonono'
      axios.get(`http://dev.logical.net/api/page/2`)
        .then(response => {
        this.msg = response
      })
    }
  }
}
</script>

<style scoped>

</style>
