<script setup>
import { Chart, registerables } from "chart.js";
import { BarChart } from "vue-chart-3";
import { reactive, computed } from 'vue';

const props = defineProps({
  data: Object,
})

const labels = computed(() => props.data.labels)
const totals = computed(() => props.data.totals)

Chart.register(...registerables);

const barData = reactive({
  labels:  labels,
  datasets: [
    {
      label: '売上',
      data: totals,
      backgroundColor: "rgb(75,192,192)",
    }
  ],
  options: {
    responsive: true,
  }
})

</script>

<template>
<div v-show="props.data">
    <BarChart :chartData="barData" class="chart-container" style="position: relative; height: 50vh; width: 80vw;"/>
</div>
</template>