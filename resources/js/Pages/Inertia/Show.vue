<script setup>
import { Inertia } from '@inertiajs/inertia';

defineProps({
  id : String,
  blog: Object,
})

const deleteConfirm = id => {
  Inertia.delete(`/inertia/${id}`, {
    onBefore: () => confirm('本当に削除しますか？')
  })
}
</script>

<template>
  {{ blog.title }}<br>
  <button @click="deleteConfirm(blog.id)">削除</button>
</template>