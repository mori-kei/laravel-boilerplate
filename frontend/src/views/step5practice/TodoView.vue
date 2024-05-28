<template>
    <div>
        <input type="text" v-model="todo">
        <button v-on:click="onSubmit">登録</button>
        <ul>
            <li v-for="(todo, id) in todos" :key="id">
                <input type="checkbox" v-model="todo.done" v-on:click="toggleDone(id)" v-show="!todo.done">
                <span :class="{'done':todo.done}" v-on:click="todo.done==true ? toggleDone(id): null">{{todo.text}}</span>
            </li>
        </ul> 
    </div>
</template>

<script>
import { onMounted, ref } from 'vue'
export default{
    name:'TodoView',
    setup(){
        const todos = ref([]);
        const todo = ref("");

        onMounted(() => {
            todos.value=[
            { id: 1, text: 'task1', done: false },
            { id: 2, text: 'task2', done: false },
            { id: 3, text: 'task3', done: false }
            ]
        })
        const onSubmit = () => {
            todos.value.push({  id: todos.value.length + 1,text:todo.value,done:false})
            todo.value= ""
        }
        const toggleDone = (id) => {
            todos.value[id].done = !todos.value[id].done
        }
        return{
            todos,
            todo,
            onSubmit,
            toggleDone,
        }
    }   
}
</script>

<style scoped>
ul{
    list-style: none;
}
.done {
    text-decoration: line-through; 
}
</style>