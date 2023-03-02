<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { getToday } from '@/common';
import { reactive, onMounted } from 'vue';
import Chart from '@/Components/Chart.vue';
import ResultTable from '@/Components/ResultTable.vue';


const data = reactive({})
const form = reactive({
    startDate: null,
    endDate:   null,
    type: 'perDay',
    rfmPrms : [
            30, 60, 90, 120, 
            7,5,3,2,
            300000, 200000, 100000, 30000
        ],
})



// 現在の日付を取得
onMounted(() => {
    form.startDate = getToday()
    form.endDate   = getToday()
})


const getData = async () => {
    try {
        await axios.get('/api/analysis', {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type,
                rfmPrms: form.rfmPrms,
            }
        })
        .then( res => {
            data.data = res.data.data
            if(res. data.labels) {data.labels = res.data.labels}
            if(res. data.eachCount) {data.eachCount = res.data.eachCount}
            if(res. data.totals) {data.totals = res.data.totals}
            data.type = form.type
            // console.log(res.data)
        })
    } catch (e) {
        console.log(e)
    }
}

</script>

<template>
    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">データ分析</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="getData">
                            <!-- 分析方法 -->
                            <label class="block leading-7 text-gray-600">分析方法</label>
                            <div class="relative">
                                <input type="radio" id="perDay" name="gender" v-model="form.type" value="perDay" checked/>
                                <label for="perDay" class="ml-2 mr-4 leading-7 text-sm text-gray-600">日</label>
                                <input type="radio" id="perMonth" name="gender" v-model="form.type" value="perMonth"/>
                                <label for="perMonth" class="ml-2 mr-4 leading-7 text-sm text-gray-600">月</label>
                                <input type="radio" id="perYear" name="gender" v-model="form.type" value="perYear"/>
                                <label for="perYear" class="ml-2 mr-4 leading-7 text-sm text-gray-600">年</label>
                                <input type="radio" id="decile" name="gender" v-model="form.type" value="decile"/>
                                <label for="decile" class="ml-2 mr-4 leading-7 text-sm text-gray-600">デシル分析</label>
                                <input type="radio" id="rfm" name="gender" v-model="form.type" value="rfm"/>
                                <label for="rfm" class="ml-2 mr-4 leading-7 text-sm text-gray-600">RFM分析</label>
                            </div>
                            <!-- 分析日付 -->
                            From: <input type="date" name="startDate" v-model="form.startDate">
                            To: <input type="date" name="endDate" v-model="form.endDate"><br>
                            <!-- RFM -->
                            <div v-if="form.type === 'rfm' " class="my-8">
                                <table class="mx-auto">
                                    <thead>
                                        <tr>
                                            <th>ランク</th>
                                            <th>R(〇日以内)</th>
                                            <th>F(〇回以上)</th>
                                            <th>M(〇円以上)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>5</td>
                                            <td><input type="number" v-model="form.rfmPrms[0]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[4]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[8]"></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><input type="number" v-model="form.rfmPrms[1]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[5]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[9]"></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><input type="number" v-model="form.rfmPrms[2]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[6]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[10]"></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><input type="number" v-model="form.rfmPrms[3]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[7]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[11]"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="mt-4 flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-700 rounded text-lg">分析する</button>
                        </form>

                        <!-- チャート -->
                        <div v-if="form.type != 'rfm' && data.data ">
                            <Chart :data="data"/>
                        </div>
                        <!-- テーブル -->
                        <ResultTable :data="data"/>
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
