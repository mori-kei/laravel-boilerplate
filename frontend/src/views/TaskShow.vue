<template>
    <div>
        <h2>/{{task.title }}</h2>
        <h3>内容</h3>
        <p>{{task.body }}</p>
        {{ task }}
    </div>
</template>
<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

export default {
    name:'TaskShow',
    setup() {
        const task = ref([]);
        const route = useRoute();
        const id = route.params.id;
        console.log(id)
        const fetchTask = async () => {
            const url = `http://localhost:8080/api/tasks/${id}`
            const res = await axios.get(url)
            task.value = res.data
        }
        onMounted(async () => {
            await fetchTask()
        })
        return {
            task
        }
    },
}
</script>