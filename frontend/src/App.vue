<template>
  <div class="container">
    <header>
      <div class="text-right">
        <div v-if="user">
          <span>{{ user.name }}</span>
          <span v-if="user.role === 1">[管理者]</span>
          <a href="javascript:void(0)" @click="handleLogout">ログアウト</a>
        </div>
        <div v-else-if="user === undefined">...</div>
        <div v-else><router-link to="/login">ログイン</router-link>して利用してください</div>
      </div>
      <nav>
        <router-link to="/">Home</router-link> |
        <router-link to="/about">About</router-link>

        <template v-if="user">
          <template v-if="user.role === 1">
            | <router-link :to="{ name: 'adminUsers' }">Admin/Users</router-link>
          </template>
        </template>
      </nav>
    </header>
    <FlashMessage></FlashMessage>
    <router-view />
  </div>
</template>

<style>
.container {
  max-width: 1024px;
  margin: 0 auto;
}

.text-right {
  text-align: right;
}

table.standard {
  width: 100%;
}

table.standard thead {
  background-color: lightgray;
}

table.standard td {
  text-align: center;
}

.mini-panel {
  max-width: 640px;
  margin: 0 auto;
}

.form-group {
  margin-bottom: 4px;
}

.form-group label {
  display: block;
}
</style>

<script setup>
import { ref, provide } from 'vue'
import { userKey } from '@/keys'
import axios from 'axios'
import FlashMessage from '@/components/FlashMessage.vue'
import { flashMessageKey } from './keys'
import { useRouter } from 'vue-router'

const user = ref()
provide(userKey, user)

const message = ref()
const flashMessageStore = {
  message,
  setMessage: (msg) => {
    message.value = msg

    setTimeout(() => {
      message.value = null
    }, 5000)
  }
}
provide(flashMessageKey, flashMessageStore)

const router = useRouter()

;(async () => {
  try {
    const res = await axios.get('/api/user')
    user.value = res.data
  } catch (err) {
    user.value = null
    console.log('ログインしていません')
  }
})()

const handleLogout = async () => {
  await axios.post('/api/logout')
  user.value = null
  flashMessageStore.setMessage('ログアウトしました')
  
  router.push('/')
}
</script>
