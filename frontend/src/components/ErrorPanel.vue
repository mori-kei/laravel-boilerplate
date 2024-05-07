<template>
  <div class="error-panel" v-if="error.message || error.errors">
    <h3 class="alert alert-danger">エラーが発生しました</h3>
    <ul v-if="error.errors">
      <li v-for="(error, key) in error.errors" v-bind:key="key">{{ error.join(',') }}</li>
    </ul>
    <div v-else-if="error.message">
      {{ error.message }}
    </div>
  </div>
</template>

<style scoped>
.error-panel {
  background-color: pink;
  color: darkred;
  padding: 2px 4px;
}
</style>

<script setup>
import { defineProps } from 'vue'

defineProps(['error'])
</script>
