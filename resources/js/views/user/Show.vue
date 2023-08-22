<template>
    <div class="w-3/4 mx-auto">
        <div v-if="posts">
            <h2 class="mb-2 pb-2 mt-4 border-b border-gray-400 font-bold">Posts</h2>
            <Post v-for="post in posts" :post="post"></Post>
        </div>
    </div>
</template>
<script>
import Post from "../../components/Post.vue";

export default {
    name: "Show",
    components: {Post},
    data() {
        return {
            posts: [],
            userId: this.$route.params.id
        }
    },
    mounted() {
        this.getPost()
    },
    methods: {
        getPost() {
            axios.get(`/api/users/${this.userId}/posts`)
                .then(res => {
                    this.posts = res.data.data
                    console.log(this.posts);
                })
                .catch(e => {
                    console.log(e)
                })
        }
    }
}
</script>

<style scoped>

</style>
