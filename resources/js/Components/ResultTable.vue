<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  'data': Object,
})

</script>

<template>
  <!-- 年月日 -->
<div v-if="data.type === 'PerDay' || data.type === 'PerMonth' || data.type === 'PerYear'" class="lg:w-2/3 w-full mx-auto overflow-auto">
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
</template>