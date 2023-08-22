<template>
    <div class="w-3/4 mx-auto">
        <div>
            <div class="mb-3">
                <input type="text" v-model="title" placeholder="title"
                       class="w-96 border p-2 rounded-3xl border-slate-700 border-1">
                <div v-if="errors">
                    <p v-for="error in errors.title" class="text-red-800">{{error}}</p>
                </div>
            </div>
            <div class="mb-3">
                <textarea v-model="content" placeholder="content"
                          class="w-96 border p-2 rounded-3xl border-slate-700 border-1">
                </textarea>
                <div v-if="errors">
                    <p v-for="error in errors.content" class="text-red-800">{{error}}</p>
                </div>
            </div>
            <div class="flex justify-between w-96">
                <input
                    @change="storeImage"
                    type="file"
                    ref="file"
                    class="hidden"
                />
                <a @click.prevent="createPost"
                   href="#"
                   class="block text-center border p-2 w-32 rounded-lg border-green-900 bg-lime-600 hover:bg-lime-300">Publish</a>
                <a @click.prevent="selectedImage"
                   href="#"
                   class="block text-center border p-2 w-32 rounded-lg border-green-900 bg-lime-600 hover:bg-lime-300">Image</a>
            </div>
            <div>
                <img v-if="image" :src="image.url" alt="image post">
                <a href="#"
                   @click.prevent="cancelImage"
                   v-if="image"
                   class="block text-center border p-2 w-32 rounded-lg border-green-900 bg-red-600 hover:bg-lime-300"
                >cancel</a>
            </div>
        </div>
        <div v-if="posts">
            <h2 class="mb-2 pb-2 mt-4 border-b border-gray-400 font-bold">Posts</h2>
            <Post v-for="post in posts" :post="post"></Post>
        </div>

    </div>
</template>
<script>
import Post from "../../components/Post.vue";

export default {
    name: "Personal",
    data() {
        return {
            title: '',
            content: '',
            image: null,
            posts: [],
            errors: []
        }
    },
    mounted() {
        this.getPost()
    },
    components: {
        Post
    },
    methods: {
        getPost() {
            axios.get('/api/get_all_post')
                .then(res => {
                    this.posts = res.data.data
                })
                .catch(e => {
                    console.log(e)
                })
        },
        storeImage(event) {
            const file = event.target.files[0];
            const formData = new FormData
            formData.append('image', file)
            axios.post('/api/post_image', formData)
                .then(res => {
                    this.image = res.data.data
                    console.log(res)
                }).catch(e => {
                console.log(e)
            })
        },
        selectedImage() {
            this.fileInput = this.$refs.file
            this.fileInput.click()
        },
        createPost() {
            const postData = {
                content: this.content,
                title: this.title,
                postImageId: this.image ? this.image.id : null
            };

            axios.post('/api/post', postData)
                .then(res => {
                    this.image = null;
                    this.content = '';
                    this.title = '';
                    this.posts.unshift(res.data.data)
                })
                .catch(err => {
                    this.errors = err.response.data.errors
                });
        },
        cancelImage() {
            axios.post('/api/delete_post_image', {image: this.image.id})
                .then(res => {
                    this.image = null
                }).catch(e => {
                console.log(e)
            })
        }
    }
}
</script>

<style scoped>

</style>
