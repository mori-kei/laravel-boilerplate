<template>
    <div>
        <h2 v-if="task.team">{{task.team.name}}/{{task.title}}</h2>
        <h3>内容</h3>
        <p>{{task.body }}</p>
        <h3>コメント</h3>
        <div v-for="comment in comments" :key="comment.id">
        <p>{{comment.message}}</p>
        <p>{{comment.created_at}} by {{comment.authorname }}</p>
</div>
    </div>
</template>
<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

export default {
    name:'TaskShow',
    setup() {
        const task = ref({});
        const comments = ref({})
        const route = useRoute();
        const id = route.params.id;
        const fetchTask = async () => {
            const url = `http://localhost:8080/api/tasks/${id}`
            const res = await axios.get(url)
            task.value = res.data.task
        }
        const fetchComments = async () => {
            const url = `http://localhost:8080/api/tasks/${id}/comments`
            const res = await axios.get(url)
            comments.value = res.data.comments
            console.log(comments)
        }
        onMounted(async () => {
            await fetchTask()
            await fetchComments()
        })
        return {
            task,
            comments
        }
    },
}
</script>