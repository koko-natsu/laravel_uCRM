<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
  items: Array,
  order: Array,
})

/* 日付、Itemの変換処理 */
onMounted(() =>{
  console.log(props.items)
  console.log(props.order)
})

</script>

<template>
  <Head title="内訳" />
  
  <AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          購入内訳
        </h2>
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
            <div class="container px-5 py-8 mx-auto">
              <div class="lg:w-1/2 md:w-2/3 mx-auto">
                <div class="flex flex-wrap -m-2">
                    <!-- 日付 -->
                    <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">日付</label>
                          <div name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                          {{ dayjs(props.order[0].created_at).format('YY/MM/DD') }}
                          </div>
                        </div>
                    </div>
                    <!-- 顧客名 -->
                    <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">顧客名</label>
                          <div name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                            {{ props.order[0].customer_name }}
                          </div>
                        </div>
                    </div>
                    <!-- 表 -->
                    <div class="w-full mx-auto mt-5">
                      <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                          <tr>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">金額</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">数量</th>
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">小計</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="item in props.items">
                              <td class="text-sm text-gray-900 font-light px-6 py-4">{{ item.item_id }}</td>
                              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ item.item_name }}</td>
                              <td class="text-sm text-gray-900 font-light px-0 py-4 whitespace-nowrap">{{ item.item_price }}</td>
                              <td class="text-sm text-gray-900 font-light px-0 py-4 whitespace-nowrap">{{ item.quantity }}</td>
                              <td class="text-sm text-gray-900 font-light whitespace-nowrap">{{ item.subtotal }}</td>
                            </tr>
                        </tbody>
                      </table>
                      <!-- 合計金額 -->
                      <div class="p-2 w-full">
                        <label class="leading-7 text-sm text-gray-600">合計</label>
                        <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300  outline-none text-gray-700 py-1 px-3 leading-8">
                          {{ props.order[0].total }} 円
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <label class="leading-7 text-sm text-gray-600">ステータス</label>
                        <div v-if="props.order[0].status == 0" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">未キャンセル</div>
                        <div v-else-if="props.order[0].status == 1" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">キャンセル済
                        </div>
                      </div>

                      <div v-if="props.order[0].status == 1" class="p-2 w-full">
                        <label class="leading-7 text-sm text-gray-600">キャンセル日</label>
                        <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                          {{ dayjs(props.order[0].updated_at).format('YY/MM/DD') }}
                        </div>
                      </div>

                      <div v-if="props.order[0].status === 0" class="w-full">
                        <Link as="button" :href="route('purchases.edit', { purchase: props.order[0].id})" class="flex mt-5 mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集</Link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>