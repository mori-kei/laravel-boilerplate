<template>
  <div class="users">
    <h2>Admin/Users</h2>
    <div class="text-right">
      <router-link :to="{ name: 'adminUserCreate' }">新規作成</router-link>
    </div>

    <error-panel :error="error"></error-panel>

    <div v-if="users === undefined">...</div>
    <table v-else class="standard">
      <thead>
        <th>ID</th>
        <th>権限</th>
        <th>名前</th>
        <th>Email</th>
        <th>操作</th>
      </thead>
      <tbody>
        <tr v-for="user in users" v-bind:key="user.id">
          <th>{{ user.id }}</th>
          <td>{{ { 0: '通常', 1: '管理者' }[user.role] }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
            <router-link :to="{ name: 'adminUserEdit', params: { id: user.id } }">編集</router-link>
            <template v-if="currentUser.id !== user.id">
              &nbsp;
              <a @click.prevent="handleDelete(user)" href="#">削除</a>
            </template>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { inject, ref } from 'vue'
import axios, { AxiosError } from 'axios'
import { userKey, flashMessageKey } from '@/keys'
import ErrorPanel from '@/components/ErrorPanel.vue'

const currentUser = inject(userKey) // ログイン中のユーザー取得
const users = ref()
const { setMessage } = inject(flashMessageKey) // flashメッセージに設定する関数の取得

const error = ref({})

const reloadUsers = async () => {
  try {
    const res = await axios.get('/api/users')
    users.value = res.data
  } catch (err) {
    error.value = { message: err.message }
  }
}

;(async () => {
  await reloadUsers()
})()

const handleDelete = async (user) => {
  if (!window.confirm('本当に削除しますか？')) {
    return
  }

  error.value = {}

  try {
    await axios.delete(`/api/users/${user.id}`)
    await reloadUsers()
    setMessage('削除しました')
  } catch (err) {
    if (err instanceof AxiosError && err.response.status === 422) {
      error.value = err.response.data
    } else {
      error.value = { message: err.message }
    }
  }
}
</script>
