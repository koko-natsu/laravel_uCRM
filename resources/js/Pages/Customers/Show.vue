<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { nl2br } from '@/common';
import { Inertia } from '@inertiajs/inertia';

defineProps({
  customer: Object
})

const deleteItem = id => {
  Inertia.delete(route('customers.destroy', { customer: id }), {
    onBefore: () => confirm('本当に削除しますか？')
  })
}
</script>


<template>
<Head title="顧客詳細" />

<AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          顧客詳細
        </h2>
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <section class="text-gray-600 body-font relative">
                <div class="container px-5 py-8 mx-auto">
                  <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div class="flex flex-wrap -m-2">
                      <!-- 名前 -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">商品名</label>
                          <div id="name"  class="w-full h-10 bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8">{{ customer.name }}</div>
                        </div>
                      </div>
                      <!-- 送り仮名 -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">送り仮名</label>
                          <div id="kana"  class="w-full h-10 bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8 ">{{ customer.kana }}</div>
                        </div>
                      </div>
                      <!-- 電話番号 -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">電話番号</label>
                          <div id="tel"  class="w-full h-10 bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8">{{ customer.tel }}</div>
                        </div>
                      </div>
                      <!-- メールアドレス -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">メールアドレス</label>
                          <div id="email"  class="w-full h-10 bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8">{{ customer.email }}</div>
                        </div>
                      </div>
                      <!-- 郵便番号 -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">郵便番号</label>
                          <div id="postcode"  class="w-full h-10 bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8">{{ customer.postcode }}</div>
                        </div>
                      </div>
                      <!-- 住所 -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">住所</label>
                          <div id="address"  class="w-full h-10 bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8">{{ customer.address }}</div>
                        </div>
                      </div>
                      <!-- 誕生日 -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">誕生日</label>
                          <div id="birthday"  class="w-full h-10 bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8">{{ customer.birthday }}</div>
                        </div>
                      </div>
                      <!-- 性別 -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">性別</label>
                          <div id="gender"  class="w-full h-10 bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8">
                            <span v-if="customer.gender === 0">女性</span>
                            <span v-if="customer.gender === 1">男性</span>
                            <span v-if="customer.gender === 2">他</span>
                          </div>
                        </div>
                      </div>
                      <!-- メモ -->
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                          <div id="memo" class="whitespace-pre-wrap w-full h-32 scrollspy bg-opacity-50 rounded border border-gray-300 text-base text-gray-700 py-1 px-3 leading-8">{{ customer.memo }}</div>
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <button class="flex mx-auto text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">
                         <Link :href="route('customers.edit', {customer: customer.id})">
                            編集
                        </Link>
                        </button>
                      </div>

                      <div class="p-2 w-full">
                        <button @click="deleteItem(customer.id)" class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除</button>
                      </div>

                    </div>
                  </div>
                </div>
              </section>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>

<style>
.scrollspy {
  overflow: auto;
}
</style>