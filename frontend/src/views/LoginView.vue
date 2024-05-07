<template>
  <div>
    <h2>ログイン</h2>
    <div class="mini-panel">
      <error-panel :error="error"></error-panel>
      <form v-on:submit.prevent="handleLogin">
        <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" v-model="email" :disabled="blocking" />
        </div>

        <div class="form-group">
          <label>パスワード</label>
          <input type="password" name="password" v-model="password" :disabled="blocking" />
        </div>

        <input type="submit" value="ログイン" />
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'
import axios, { AxiosError } from 'axios'
import { flashMessageKey, userKey } from '../keys'
import ErrorPanel from '@/components/ErrorPanel.vue'

const error = ref({})
const blocking = ref(false)

const email = ref('')
const password = ref('')

const user = inject(userKey)
const router = useRouter()
const { setMessage } = inject(flashMessageKey)

const handleLogin = async () => {
  error.value = {}
  blocking.value = true

  try {
    await axios.get('/sanctum/csrf-cookie')
    const res = await axios.post('/api/login', { email: email.value, password: password.value })
    user.value = res.data

    setMessage('ログインしました')
    router.push('/')
  } catch (err) {
    if (err instanceof AxiosError && err.response.status === 422) {
      error.value = err.response.data
    } else if (err instanceof AxiosError && err.response.status === 401) {
      error.value = { message: 'Emailかパスワードが間違っています' }
    } else {
      error.value = { message: err.message }
    }
  }

  blocking.value = false
}
</script>
