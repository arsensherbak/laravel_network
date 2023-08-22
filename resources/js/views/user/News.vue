<template>
    <div class="w-3/4 mx-auto">
        <div v-if="posts">
            <h2 class="mb-2 pb-2 mt-4 border-b border-gray-400 font-bold text-center">Новости подписчиков</h2>
            <Post v-for="post in posts" :post="post"></Post>
        </div>
        <div v-else>
            <h2 class="mb-2 pb-2 mt-4 border-b border-gray-400 font-bold text-center">Нет никаких новостей</h2>

        </div>
    </div>
</template>
<script >
import Post from "../../components/Post.vue";
export default {
    name: "News",
    data(){
        return {
            posts: null
        }
    },
    components: {
        Post
    },
    mounted() {
        this.getNews()
    },
    methods: {
        getNews(){
            axios.get('/api/get_news')
                .then(res => {
                    console.log(res.data.data);
                    this.posts = res.data.data
                })
                .catch(e => {
                    console.log(e);
                })
        }
    }
}
</script>
