<script setup>
</script>

<template>
  <!-- Success -->
  <div v-if="$page.props.flash.status === 'success'" class="bg-blue-300 text-white p-4">
    {{ $page.props.flash.message }}
  </div>
  <!-- Danger -->
  <div v-if="$page.props.flash.status === 'danger'" class="bg-red-300 text-white p-4">
    {{ $page.props.flash.message }}
  </div>
</template>