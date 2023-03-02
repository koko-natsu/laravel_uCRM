<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  'data': Object,
})

</script>

<template>
  <!-- 年月日 -->
<div v-if="data.type === 'perDay' || data.type === 'perMonth' || data.type === 'perYear'" class="lg:w-2/3 w-full mx-auto overflow-auto">
    <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <tr>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">日付</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">合計金額</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data.data" :key="item.date">
            <td class="px-4 py-3">{{ item.date }}</td>
            <td class="px-4 py-3">{{ item.total }}</td>
          </tr>
        </tbody>
    </table>
</div>

<!-- デシル分析 -->
<div v-if="data.type === 'decile'" class="lg:w-2/3 w-full mx-auto overflow-auto">
    <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <tr>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Group ID</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">平均金額</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">合計金額</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">構成比</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data.data" :key="item.date">
            <td class="px-4 py-3">{{ item.decile }}</td>
            <td class="px-4 py-3">{{ item.average }}</td>
            <td class="px-4 py-3">{{ item.totalPerGroup }}</td>
            <td class="px-4 py-3">{{ item.totalRatio }}</td>
          </tr>
        </tbody>
    </table>
</div>

<div v-if="data.type === 'rfm'" class="lg:w-2/3 w-full mx-auto overflow-auto">
  <h2 class="mt-8 text-center text-2xl">RFM 分析結果</h2>
    <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <tr>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Rank</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">R</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">F</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">R</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="rfm in data.eachCount" :key="rfm.rank">
            <td class="px-4 py-3">{{ rfm.rank }}</td>
            <td class="px-4 py-3">{{ rfm.r }}</td>
            <td class="px-4 py-3">{{ rfm.f }}</td>
            <td class="px-4 py-3">{{ rfm.m }}</td>
          </tr>
        </tbody>
    </table>

    <h2 class="mt-10 text-center text-2xl">RF 分析結果</h2>
    <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <tr>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">rRank</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">f_5</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">f_4</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">f_3</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">f_2</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">f_1</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="rf in data.data" :key="rf.rank">
            <td class="px-4 py-3">{{ rf.rRank }}</td>
            <td class="px-4 py-3">{{ rf.f_5 }}</td>
            <td class="px-4 py-3">{{ rf.f_4 }}</td>
            <td class="px-4 py-3">{{ rf.f_3 }}</td>
            <td class="px-4 py-3">{{ rf.f_2 }}</td>
            <td class="px-4 py-3">{{ rf.f_1 }}</td>
          </tr>
        </tbody>
    </table>
</div>

</template>