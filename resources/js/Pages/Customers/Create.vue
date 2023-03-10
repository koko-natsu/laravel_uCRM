<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Core as YubinBangoCore } from "yubinbango-core2";

defineProps({
  errors: Object
});

const form = reactive({
  name: null, 
  kana: null,
  tel: null,
  email: null,
  postcode: null,
  address: null,
  birthday: null,
  gender: null,
  memo: null,
})

const storeCustomer = () => {
  Inertia.post('/customers', form)
}

const fetchAddress = () => {
  new YubinBangoCore(String(form.postcode), (value) => {
    form.address = value.region + value.locality + value.street
  })
}
</script>


<template>
    <Head title="顧客登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              顧客登録
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <form @submit.prevent="storeCustomer">
                    <section class="text-gray-600 body-font relative">
                      <div class="container px-5 py-8 mx-auto">
                        <div class="lg:w-1/2 md:w-2/3 mx-auto">
                          <div class="flex flex-wrap -m-2">
                            <!-- 顧客名 -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                                <input type="text" id="name" name="name" v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              </div>
                              <InputError class="mt-2" :message="errors.name" />
                            </div>
                            <!-- 送り仮名 -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label for="kana" class="leading-7 text-sm text-gray-600">送り仮名</label>
                                <input type="text" id="kana" name="kana" v-model="form.kana" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              </div>
                              <InputError class="mt-2" :message="errors.kana" />
                            </div>
                            <!-- 電話番号 -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                <input type="number" id="tel" name="tel" v-model="form.tel" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              </div>
                              <InputError class="mt-2" :message="errors.tel" />
                            </div>
                            <!-- E mail -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                <input type="email" id="email" name="email" v-model="form.email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              </div>
                              <InputError class="mt-2" :message="errors.email" />
                            </div>
                            <!-- 郵便番号 -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                                <input type="number" id="postcode" name="postcode" @change="fetchAddress" v-model="form.postcode" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              </div>
                              <InputError class="mt-2" :message="errors.postcode" />
                            </div>
                            <!-- 住所 -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                <input type="text" id="address" name="address" v-model="form.address" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                              </div>
                              <InputError class="mt-2" :message="errors.address" />
                            </div>
                            <!-- 誕生日 -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label for="birthday" class="leading-7 text-sm text-gray-600">誕生日</label>
                                <input type="date" id="birthday" name="birthday" v-model="form.birthday" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                              </div>
                              <InputError class="mt-2" :message="errors.birthday" />
                            </div>
                            <!-- 性別 -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label class="block leading-7 text-sm text-gray-600">性別</label>
                                <input type="radio" id="female" name="gender" v-model="form.gender" value="0"/>
                                <label for="female" class="ml-2 mr-4">女性</label>
                                <input type="radio" id="male" name="gender" v-model="form.gender" value="1" class="ml-4"/>
                                <label for="male" class="ml-2 mr-4">男性</label>
                                <input type="radio" id="else" name="gender" v-model="form.gender" value="3" class="ml-4"/>
                                <label for="else" class="ml-2 mr-4">他</label>
                              </div>
                              <InputError class="mt-2" :message="errors.gender" />
                            </div>

                            <!-- メモ -->
                            <div class="p-2 w-full">
                              <div class="relative">
                                <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                              </div>
                              <InputError class="mt-2" :message="errors.memo" />
                            </div>
                            
                            <div class="p-2 w-full">
                              <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                  </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
