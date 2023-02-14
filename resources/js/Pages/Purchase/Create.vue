<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive, ref, computed } from 'vue';
import { getToday } from '@/common';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  errors: Object,
  customers: Array,
  items: Array,
})

const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]
const itemList = ref([])
const form = reactive({
  date: null,
  customer_id: null,
  status: true,
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

const storePurchase = () => {
  itemList.value.forEach(item => {
    if(item.quantity > 0) {
      form.items.push({
        id: item.id,
        quantity: item.quantity,
      })
    }
})
Inertia.post(route('purchases.store'), form)
}

/* 日付、Itemの変換処理 */
onMounted(() =>{
  form.date = getToday();

  props.items.forEach(item => {
    itemList.value.push({
      id: item.id,
      name: item.name,
      price: item.price,
      quantity: 0,
    })
  })
})


</script>

<template>
  <Head title="購入画面" />
  
  <AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          購入画面
        </h2>
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <form @submit.prevent="storePurchase">
            <div class="container px-5 py-8 mx-auto">
              <div class="lg:w-1/2 md:w-2/3 mx-auto">
                <div class="flex flex-wrap -m-2">
                    <!-- 日付 -->
                    <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">日付</label>
                          <input type="date" name="date" v-model="form.date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                        </div>
                    </div>
                    <!-- 顧客名 -->
                    <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">顧客名</label>
                          <select name="customer" v-model="form.customer_id" class="w-full h-10 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            <option v-for="customer in customers" :value="customer.id" :key="customer.id">
                              {{ customer.id }} : {{ customer.name }}
                            </option>
                          </select>
                          <InputError class="mt-2" :message="props.errors.customer_id" />
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
                        <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          {{ sumPirce }} 円
                        </div>
                      </div>

                       <button class="flex mt-5 mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">購入</button>
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