<template>
    <div class="mb-8 pb-8 border-b border-gray-300">
        <h2 class="break-words text-xl font-bold mb-2">{{ post.title }}</h2>
        <img :src="post.url" alt="">
        <p class="break-words">{{ post.content }}</p>
        <div v-if="post.reposted" class="bg-gray-100 p-4">
            <h2 class="break-words text-xl font-bold mb-2">{{ post.reposted.title }}</h2>
            <img :src="post.reposted.url" alt="">
            <p class="break-words">{{ post.reposted.content }}</p>
        </div>
        <div class="flex justify-between ">
            <div class="mt-2 flex">
                <svg @click.prevent="liked(post)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor"
                     :class="[ 'hover:fill-sky-500 cursor-pointer w-6 h-6', post.like ?'fill-sky-500' :'fill-white ']">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                <span>{{ post.like_count }}</span>
                <div title="created repost">
                    <svg @click="openReposted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/>
                    </svg>
                </div>
                <span>{{ post.repost_count }}</span>
                <div title="Leave a comment">
                    <svg @click="openComment" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor"
                         class="w-6 h-6 mx-1 fill-white hover:fill-sky-500 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                    </svg>
                </div>
                <span>{{ post.comments_count }}</span>
                <div v-if="post.comments_count > 0" @click="showComments" title="show comments">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         @click="comments.length === 0 ? getComments(post) : null"
                         class="w-6 h-6 mx-1 fill-white hover:fill-sky-500 cursor-pointer"
                         title="Show Comments">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>

                </div>

            </div>
            <div class="flex">
                <p class="text-right text-slate-500 p-1">{{ post.date }}</p>
                <p class="text-right text-slate-500 p-1">{{ post.name }}</p>
            </div>
        </div>
        <div v-if="is_reposted">
            <div>
                <input type="text" v-model="title" placeholder="title"
                       class="w-96 mb-3 border p-2 rounded-3xl border-slate-700 border-1">
            </div>
            <div>
                <textarea v-model="content" placeholder="content"
                          class="w-96 border p-2 mb-3 rounded-3xl border-slate-700 border-1">
                </textarea>
            </div>
            <a @click.prevent="repostPost(post)"
               href="#"
               class="block text-center border p-2 w-32 rounded-lg border-green-900 bg-lime-600 hover:bg-lime-300">Repost</a>

        </div>
        <div v-if="is_comment">
            <div>
                <input type="text" v-model="body" placeholder="title"
                       class="w-96 mb-3 border p-2 rounded-3xl border-slate-700 border-1">
            </div>
            <a @click.prevent="addComment(post)"
               href="#"
               class="block text-center border p-2 w-32 rounded-lg border-green-900 bg-lime-600 hover:bg-lime-300">Comment</a>
        </div>
        <div v-if="is_show_comments">
            <div v-if="comments" v-for="comment in comments" :key="comment.id">
                <div class="bg-white shadow-md p-4 mb-4 rounded-lg">
                    <h4 class="text-xl font-bold mb-2">{{ comment.body }}</h4>
                    <h5 class="text-sl font-semibold mb-2">{{ comment.name }}</h5>
                    <div @click="openAnswer(comment.id)" class="text-sm text-sky-500 cursor-pointer">answer</div>
                </div>
                <div v-if="active_comment_id === comment.id" class="bg-white shadow-md p-4 mb-4 rounded-lg">
                    <input type="text" v-model="answer" placeholder="title"
                           class="w-96 mb-3 border p-2 rounded-3xl border-slate-700 border-1">
                    <a @click.prevent="addAnswer(comment, post)"
                       href="#"
                       class="block text-center border p-2 w-32 rounded-lg border-green-900 bg-lime-600 hover:bg-lime-300">answer</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "Post",
    props: [
        'post'
    ],
    data() {
        return {
            is_reposted: false,
            is_comment: false,
            is_show_comments: false,
            post_id: null,
            content: '',
            title: '',
            body: '',
            is_answer: false,
            comments: [],
            answer:'',
            active_comment_id: null,
        }
    },
    methods: {
        liked(post) {
            axios.post('/api/add_liked', {post_id: post.id})
                .then(res => {
                    post.like = !post.like;
                    post.like_count = res.data
                })
                .catch(e => {
                    console.log(e)
                })
        },
        openReposted() {
            this.is_reposted = !this.is_reposted
        },
        openAnswer(comment_id) {
            if (this.active_comment_id === comment_id) {
                this.active_comment_id = null;
            } else {
                this.active_comment_id = comment_id;
            }
        },
        showComments() {
            this.is_show_comments = !this.is_show_comments
        },
        openComment() {
            this.is_comment = !this.is_comment
        },
        repostPost(post) {
            axios.post(`/api/posts/repost`, {reposted_id: post.id, content: this.content, title: this.title})
                .then(res => {
                    console.log(res.data)
                    this.content = ''
                    this.title = ''
                    this.is_reposted = false
                }).catch(e => {
                console.log(e);
            })
        },
        addComment(post) {
            axios.post(`/api/posts/comment`, {body: this.body, post_id: post.id})
                .then(res => {
                    this.comments.push(res.data.data)
                    post.comments_count++
                    this.is_reposted = false
                    this.body = ''
                }).catch(e => {
                console.log(e);
            })
        },
        getComments(post) {
            axios.post('/api/post/comments', {post_id: post.id})
                .then(res => {
                    this.comments = res.data.data
                })
                .catch(e => {
                    console.log(e)
                })
        },
        addAnswer(comment, post){
           axios.post('/api/add_answer',{
               comment_id: comment.id, post_id: post.id, answer: this.answer, answer_name: comment.name

           }).then(res => {
               this.answer = ''
               console.log(res)
           }).catch(e =>{
               console.log(e)
           })
        }
    }
}
</script>

<style scoped>

</style>
