<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import Pagination from '@/Components/Pagination.vue';
import { onMounted, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const search = ref('')

const props = defineProps({
  customers: Object,
  count: Number,
})

const searchCustomers = () => {
  Inertia.get(route('customers.index'), { search: search.value })
}

// onMounted(() => {
//   console.log(props.customers.links)
// })

</script>


<template>
    <Head title="顧客一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              顧客一覧
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                          <div class="container px-5 py-8 mx-auto">
                            <FlashMessage />
                            <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                              <!-- 検索 -->
                              <div>
                                <input type="text" name="search" v-model="search" />
                                <button @click="searchCustomers" class="ml-4 bg-blue-300 text-white py-2 px-2">
                                  検索
                                </button>
                                <span v-if="count > 0">{{ count }}件ヒット</span>
                                <span v-else></span>
                                <!-- <span class="ml-4">{{ count }}件ヒット</span> -->
                              </div>
                              <!-- 顧客新規登録 -->
                              <Link as="button" :href="route('customers.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">顧客登録</Link>
                            </div>
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                              <!-- 顧客リスト -->
                              <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                  <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">指名</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">カナ</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">電話番号</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="customer in customers.data" :key="customer.id">
                                    <td class="px-4 py-3"><Link class="text-blue-400" :href="route('customers.show', { customer: customer.id })">{{ customer.id }}</Link></td>
                                    <td class="px-4 py-3">{{ customer.name }}</td>
                                    <td class="px-4 py-3">{{ customer.kana }}</td>
                                    <td class="px-4 py-3">{{ customer.tel }}</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <Pagination class="mt-6" :links="customers.links"></Pagination>
                          </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
