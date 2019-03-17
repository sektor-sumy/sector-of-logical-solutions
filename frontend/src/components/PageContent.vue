<template>
    <div>
        <page-menu/>
        <div class="container">
            <div class="row">

                <div class="col-lg-8">
                    <h1 class="mt-4">{{ content.title }}</h1>
                    <hr>

                    <p>Posted on {{ content.created_at }}</p>
                    <hr>

                    <div>{{ content.content }}</div>
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
        name: 'page-content',
        components: {
            PageMenu: PageMenu,
            PageFooter: PageFooter,
            PageWidget: PageWidget
        },
        data() {
            return {
                content: {}
            }
        },
        mounted: function () {
            if (this.$route.path === '/') {
                axios.get(`${this.$root.host}/api/page?homepage=true`)
                    .then(response => {
                        this.content = response.data;
                        document.title = this.content.title;
                    })
            } else {
                axios.get(`${this.$root.host}/api/page` + this.$route.path)
                    .then(response => {
                        this.content = response.data;
                        document.title = this.content.title;
                    })
            }
        }
    }
</script>

<style>
</style>
