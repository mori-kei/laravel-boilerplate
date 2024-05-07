<template>
  <div class="flash-message" v-if="message">{{ message }}</div>
</template>

<style scoped>
.flash-message {
  background-color: lightblue;
  color: blue;
  padding: 2px 4px;
}
</style>

<script setup>
import { inject } from 'vue'
import { flashMessageKey } from '@/keys'

const { message } = inject(flashMessageKey)
</script>
