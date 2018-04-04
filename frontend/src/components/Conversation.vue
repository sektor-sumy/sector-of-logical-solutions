<template>
    <div>
        <page-menu/>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="mt-4">Conversation</h1>

                    <div class="chat-message" id="body-chat">
                        <ul class="chat">
                            <div
                                v-for="item in conversation.conversationReplies"
                                :key="item.id"
                                >
                                <li class="right" v-if="item.author == conversation.email">
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font"> {{ item.author }}</strong>
                                            <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> {{ item.createdAt }}</small>
                                        </div>
                                        <p>
                                            {{ item.reply }}
                                        </p>
                                    </div>
                                </li>
                                <li class="left" v-else>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font"> {{ item.author }}</strong>
                                            <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> {{ item.createdAt }}</small>
                                        </div>
                                        <p>
                                            {{ item.reply }}
                                        </p>
                                    </div>
                                </li>
                            </div>
                        </ul>
                    </div>
                    <div class="chat-box bg-white">
                        <div class="input-group">
                            <input v-on:keyup.enter="sendReply" v-model="writetext" class="form-control border no-shadow no-rounded" placeholder="Type your message here">
                            <span class="input-group-btn"><button @click="sendReply" class="btn btn-success no-rounded" type="button">Send</button></span>
                        </div>
                    </div>
                </div>
                <page-widget/>
            </div>
        </div>
        <page-footer/>
    </div>
</template>

<script>
import axios from 'axios'
import PageMenu from '../components/Page/PageMenu'
import PageFooter from '../components/Page/PageFooter'
import PageWidget from '../components/Page/PageWidget'
export default {
  name: 'conversation',
  components: {
    PageMenu: PageMenu,
    PageFooter: PageFooter,
    PageWidget: PageWidget
  },
  data () {
    return {
      conversation: {},
      lastIdReply: 0,
      writetext: '',
      chatScroll: 0
    }
  },
  mounted: function () {
    axios.get(`http://dev.logical.net/api` + this.$route.path)
      .then(response => {
      this.conversation = response.data
      this.lastIdReply++
      this.chatScroll++
    })
  },
  methods: {
    sendReply: function () {
      axios.post(`http://dev.logical.net/api/conversation_reply/addreply`, {
        email: this.conversation.email,
        text: this.writetext,
        hash: this.conversation.hash
      })
       .then(response => {
          this.lastIdReply = response.data.id

          this.conversation.conversationReplies[response.data.id + 1] = {
            author: this.conversation.email,
            createdAt: 'Now',
            reply: this.writetext
          }

          this.writetext = ''
        })
      .catch(function (error) {
        console.log(error)
      })
    }
  },
  watch: {
    lastIdReply: function () {
      setTimeout(function() {
        this.chatScroll = document.getElementById('body-chat').scrollHeight
        this.chatScroll++
        console.log(this.chatScroll)
        document.getElementById('body-chat').scrollTop = this.chatScroll
      }, 1)
    }
  }
}
</script>

<style scoped>

    .friend-list {
        list-style: none;
        margin-left: -40px;
    }

    .friend-list li {
        border-bottom: 1px solid #eee;
    }

    .friend-list li a img {
        float: left;
        width: 45px;
        height: 45px;
        margin-right: 0px;
    }

    .friend-list li a {
        position: relative;
        display: block;
        padding: 10px;
        transition: all .2s ease;
        -webkit-transition: all .2s ease;
        -moz-transition: all .2s ease;
        -ms-transition: all .2s ease;
        -o-transition: all .2s ease;
    }

    .friend-list li.active a {
        background-color: #f1f5fc;
    }

    .friend-list li a .friend-name,
    .friend-list li a .friend-name:hover {
        color: #777;
    }

    .friend-list li a .last-message {
        width: 65%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .friend-list li a .time {
        position: absolute;
        top: 10px;
        right: 8px;
    }

    small, .small {
        font-size: 85%;
    }

    .friend-list li a .chat-alert {
        position: absolute;
        right: 8px;
        top: 27px;
        font-size: 10px;
        padding: 3px 5px;
    }
    #body-chat {
        overflow-y: scroll;
    }
    .chat {
        list-style: none;
        margin: 0;
        padding: 0;
        height: 500px;
        padding: 20px;
    }


    .chat li img {
        width: 45px;
        height: 45px;
        border-radius: 50em;
        -moz-border-radius: 50em;
        -webkit-border-radius: 50em;
    }

    img {
        max-width: 100%;
    }

    .chat-body {
        padding-bottom: 20px;
    }

    .chat li.left .chat-body {
        margin-right: 70px;
        background-color: #fff;
    }

    .chat li .chat-body {
        position: relative;
        font-size: 16px;
        padding: 10px;
        border: 1px solid #f1f5fc;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }

    .chat li .chat-body .header {
        padding-bottom: 5px;
        border-bottom: 1px solid #f1f5fc;
    }

    .chat li .chat-body p {
        margin: 0;
    }

    .chat li.left .chat-body:before {
        position: absolute;
        top: 10px;
        left: -8px;
        display: inline-block;
        background: #fff;
        width: 16px;
        height: 16px;
        border-top: 1px solid #f1f5fc;
        border-left: 1px solid #f1f5fc;
        content: '';
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
    }

    .chat li.right .chat-body:before {
        position: absolute;
        top: 10px;
        right: -8px;
        display: inline-block;
        background: #fff;
        width: 16px;
        height: 16px;
        border-top: 1px solid #f1f5fc;
        border-right: 1px solid #f1f5fc;
        content: '';
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
    }

    .chat li {
        margin: 15px 0;
    }

    .chat li.right .chat-body {
        margin-left: 70px;
        background-color: #fff;
    }

    .chat-box {
        bottom: 0;
        left: 444px;
        right: 0;
        padding: 15px;
        border-top: 1px solid #eee;
        transition: all .5s ease;
        -webkit-transition: all .5s ease;
        -moz-transition: all .5s ease;
        -ms-transition: all .5s ease;
        -o-transition: all .5s ease;
    }

    .primary-font {
        color: #3c8dbc;
    }

    a:hover, a:active, a:focus {
        text-decoration: none;
        outline: 0;
    }
</style>
