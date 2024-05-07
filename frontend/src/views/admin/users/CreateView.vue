<template>
  <div>
    <h2>新規作成</h2>
    <div class="mini-panel">
      <ErrorPanel :error="error"></ErrorPanel>
      <form v-on:submit.prevent="handleSubmit">
        <div class="form-group">
          <label>名前:</label>
          <input type="text" v-model="user.name" :disabled="blocking" />
        </div>
        <div class="form-group">
          <label>Email:</label>
          <input type="text" v-model="user.email" :disabled="blocking" />
        </div>
        <div class="form-group">
          <label>パスワード:</label>
          <input type="password" v-model="user.password" :disabled="blocking" />
        </div>
        <div class="form-group">
          <label>権限:</label>
          <select v-model="user.role" :disabled="blocking">
            <option value="0">通常</option>
            <option value="1">管理者</option>
          </select>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="作成する" :disabled="blocking" />
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { inject, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios, { AxiosError } from 'axios'
import { flashMessageKey } from '@/keys'
import ErrorPanel from '@/components/ErrorPanel'

const route = useRoute()
const router = useRouter()

const user = ref({ id: route.params.id })
const error = ref({})
const blocking = ref(false)

const { setMessage } = inject(flashMessageKey)

const handleSubmit = async () => {
  error.value = {}
  blocking.value = true

  try {
    await axios.post('/api/users', user.value)
    setMessage('作成しました')
    router.push('/admin/users')
  } catch (err) {
    if (err instanceof AxiosError && err.response.status === 422) {
      error.value = err.response.data
    } else {
      error.value = { message: err.message }
    }
  }

  blocking.value = false
}
</script>
