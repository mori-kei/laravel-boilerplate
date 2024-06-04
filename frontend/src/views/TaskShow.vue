<template>
    <div >
        <div class="parent" v-if="isLogin">
            <div v-if="task.status ===1" class="finish">
                <p>このタスクは完了しました</p>
            </div>
            <h2 v-if="task.team">{{task.team.name}}/{{task.title}}</h2>
            <div class="content">
                <h3>内容</h3>
                <p>{{task.body }}</p>
                <h3>コメント</h3>
                <div v-for="comment in comments" :key="comment.id" class="comment">
                    <p>{{comment.message}}</p>
                    <p>{{comment.created_at}} by {{comment.authorname }}</p>
                </div>
                <p>本文</p>
                <textarea v-model="message" class="comment_txt"></textarea>
                <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
                <p v-if="task && task.status === 0">完了報告とする<input type="checkbox" v-model="kind"></p>
                <button v-on:click="createComment" class="btn btn-primary">送信</button>
            </div>
        </div>
        <div v-else>
            aaa
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
const isLogin = ref(false)
const task = ref({});
const comments = ref({})
const message = ref("")
const kind = ref(false)
const route = useRoute();
const errorMessage = ref("");
const id = route.params.id;
const fetchTask = async () => {
    const url = `http://localhost:8080/api/tasks/${id}`
    const res = await axios.get(url)
    return res.data.task;
}
const fetchComments = async () => {
    const url = `http://localhost:8080/api/tasks/${id}/comments`
    const res = await axios.get(url)
    return res.data.comments;
}
const createComment = async () => {
    try {
        const url = `http://localhost:8080/api/tasks/${id}/comments`;
        const res = await axios.post(url, {
            message: message.value,
            kind: kind.value ? 1 : 0,
        });
        comments.value.push(res.data[0]);
        console.log(res.data[0]);
        message.value = "";
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            const errorMessages = Object.values(validationErrors)
            errorMessage.value = errorMessages.join(', '); 
        }
    }
};

onMounted(async () => {
    try {
        const [taskData, commentsData] = await Promise.all([fetchTask(), fetchComments()]);
        task.value = taskData;
        comments.value = commentsData;
        isLogin.value = true
    } catch (error) {
        isLogin.value = false
    }
})


</script>
<style scoped>
.parent{
    background-color: #F8F9FA;
    padding: 5px;
}
.finish {
    background-color: #CEF4FC;
    color: #115160;
    padding: 5px;
    border-radius: 5px
}
.content{
    width: 80%;
    margin: 0 auto;
}
.comment{
    border-bottom: #333 solid 1px;
}
.comment_txt{
    width: 100%;
}
.error-message{
    color: red;
}
</style>
