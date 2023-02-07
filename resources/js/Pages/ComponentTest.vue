<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Label from '@/Components/InputLabel.vue';
import Input from '@/Components/TextInput.vue';

const emitTest = e => console.log(e)
</script>


<template>
<GuestLayout>
  <Label value="Title"></Label>
  <Input 
  modelValue="入力してください"
  @update:modelValue="emitTest"
  ></Input>
</GuestLayout>
</template>