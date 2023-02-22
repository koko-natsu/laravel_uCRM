<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive, ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import dayjs from 'dayjs';

const props = defineProps({
  errors: Object,
  items: Array,
  order: Array,
})

const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]
const itemList = ref([])
const form = reactive({
  id : props.order[0].id,
  date: dayjs(props.order[0].created_at).format('YY/MM/DD'),
  customer_id: props.order[0].customer_id,
  customer_name: props.order[0].customer_name,
  status: props.order[0].status,
  items: [],
})

/* 合計金額 */
const sumPirce = computed(() => {
  let total = 0
  itemList.value.forEach( item => {
    total += item.price * item.quantity
  })
  return total
})

const updatePurchase = id => {
  itemList.value.forEach(item => {
    if(item.quantity > 0) {
      form.items.push({
        id: item.id,
        quantity: item.quantity,
      })
    }
})
Inertia.put(route('purchases.update', { purchase: id}), form)
}

/* 日付、Itemの変換処理 */
onMounted(() =>{
  props.items.forEach(item => {
    itemList.value.push({
      id: item.id,
      name: item.name,
      price: item.price,
      quantity: item.quantity,
    })
  })
})

</script>

<template>
  <Head title="購入履歴 編集" />
  
  <AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          購入履歴 編集
        </h2>
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <form @submit.prevent="updatePurchase(form.id)">
              <div class="container px-5 py-8 mx-auto">
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                  <div class="flex flex-wrap -m-2">
                    <!-- 日付 -->
                    <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">日付</label>
                          <input disabled type="text" :value="form.date" name="date"  class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8" />
                        </div>
                    </div>
                    <!-- 顧客名 -->
                    <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">顧客名</label>
                          <input disabled type="text" :value="form.customer_name" name="customer" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8" />
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
                          <tr v-for="item in itemList">
                              <td class="text-sm text-gray-900 font-light px-6 py-4">{{ item.id }}</td>
                              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ item.name }}</td>
                              <td class="text-sm text-gray-900 font-light px-0 py-4 whitespace-nowrap">{{ item.price }}</td>
                              <td>
                                <select name="quantity" v-model="item.quantity">
                                  <option v-for="q in quantity" :value="q">{{ q }}</option>
                                </select>
                              </td>
                              <td class="text-sm text-gray-900 font-light whitespace-nowrap">
                                {{ item.price * item.quantity }}
                              </td>
                            </tr>
                        </tbody>
                      </table>
                      
                      <div class="p-2 w-full">
                        <label class="leading-7 text-sm text-gray-600">合計</label>
                        <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                          {{ sumPirce }} 円
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="block leading-7 text-sm text-gray-600">ステータス</label>
                          <input type="radio" id="not_canceled" name="status" v-model="form.status" value="0"/>
                          <label for="not_canceled" class="ml-2 mr-4">未キャンセル</label>
                          <input type="radio" id="cancel" name="status" v-model="form.status" value="1" class="ml-4"/>
                          <label for="cancel" class="ml-2 mr-4">キャンセル</label>
                        </div>
                        <InputError class="mt-2" :message="errors.status" />
                      </div>

                       <button class="flex mt-5 mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>