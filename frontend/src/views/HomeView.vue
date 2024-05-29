<template>
  <div class="home">
    <h2>アサインされているタスク</h2>
    <table>
      <thead >
        <tr>
          <th>チーム</th>
          <th>タスクID</th>
          <th>タイトル</th>
          <th>担当者</th>
          <th>作成日時</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody >
        <tr v-for="mytask in mytasks" :key="mytask.id">
          <td>{{mytask.team_id}}</td>
          <td>
            {{mytask.id}}
          </td>
          <td>
            {{mytask.title}}
          </td>
          <td>
            {{mytask.assignee_id}}
          </td>
          <td>
            {{mytask.created_at}}
          </td>
          <td>
            <router-link to="/">詳細</router-link>
          </td>
        </tr>
    </tbody>
    </table>
    <h2>所属しているチーム</h2>
    <table>
      <thead >
        <tr>
          <th>チームID</th>
          <th>チーム名</th>
        </tr>
      </thead>
      <tbody >
        <tr v-for="(myteam, id) in myteams" :key="id">
          <td>  {{myteam.id}}</td>
          <td>
            {{myteam.name}}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';

export default {
  name: 'HomeView',
  setup(){
    const mytasks = ref([])
    const myteams = ref([])

    const fetchMyTasks = async() => {
      const url = "http://localhost:8080/api/me/tasks"
      const res = await axios.get(url)
      mytasks.value = res.data
    }

    const fetchMyTeams = async() => {
      const url = "http://localhost:8080/api/me/teams"
      const res = await axios.get(url)
      myteams.value =res.data
    }

    onMounted(async () => {
      await Promise.all([fetchMyTasks(), fetchMyTeams()]);
    });
    return {
      mytasks,
      myteams
    }
  }
}
</script>

<style scoped>
table{
  width: 100%;
}
th{
  background-color: #D3D3D3;
}
td{
  text-align: center;
}
</style>