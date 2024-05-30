<template>
    <div>
        <h2>{{team.name}}/{{task.title }}</h2>
        <h3>内容</h3>
        <p>{{task.body }}</p>
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
        const team = ref([]);
        const route = useRoute();
        const id = route.params.id;
        const fetchTask = async () => {
            const url = `http://localhost:8080/api/tasks/${id}`
            const res = await axios.get(url)
            task.value = res.data.task
            team.value = res.data.task.team
        }
        onMounted(async () => {
            await fetchTask()
        })
        return {
            task,
            team
        }
    },
}
</script>