<template>
    <div class="w-96 mx-auto">
        <div>
            <div>
                <input type="text" v-model="title" placeholder="title"
                       class="w-96 mb-3 border p-2 rounded-3xl border-slate-700 border-1">
            </div>
            <div>
                <textarea v-model="content" placeholder="content"
                          class="w-96 border p-2 mb-3 rounded-3xl border-slate-700 border-1">
                </textarea>
            </div>
            <div class="flex justify-between">
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

    </div>
</template>
<script>
export default {
    name: "Personal",
    data() {
        return {
            title: '',
            content: '',
            image: null,
        }
    },
    mounted() {
    },
    methods: {
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
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        cancelImage(){
            axios.post('/api/delete_post_image', {image: this.image.id})
                .then(res =>{
                    this.image = null
                }).catch(e =>{
                    console.log(e)
            })
        }
    }
}
</script>

<style scoped>

</style>
