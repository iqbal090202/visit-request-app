<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionMain from "@/Components/SectionMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import FormField from "@/Components/FormField.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import { mdiChartBar, mdiAccountMultiple } from "@mdi/js";
import { Bar, Pie } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement
);

const props = defineProps({
    dailyData: {
        type: Array,
        default: () => [],
    },
    dataByPurpose:{
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    totalPerMonth: {
        type: String,
        default: "",
    },
});

// const month = ref({
//     month: new Date().getMonth(),
//     year: new Date().getFullYear(),
// });

const formFilter = useForm({
    tren: props.filters.tren,
});

const chartData = {
    labels: props.dailyData.map((object) => object.date),
    datasets: [
        {
            label: "Visit Request",
            backgroundColor: "#f87979",
            data: props.dailyData.map((object) => object.totalRequest),
        },
    ],
};

const chartOptions = {
    responsive: true,
};

const chartData2 = {
    labels: props.dataByPurpose.map(object => object.visit_purpose),
    datasets: [
        {
            backgroundColor: ['#b2c825', '#3bb548', '#3ba9b8', '#cc4bc2', '#902de0', '#f48c0f'],
            data: props.dataByPurpose.map(object => object.visit_count),
        },
    ],
};

const chartOptions2 = {
    responsive: true,
    // maintainAspectRatio: false
};

const formatMonth = (date) => {
  const month = date.toLocaleString('default', { month: 'long' });
  const year = date.getFullYear();

  return `${month} ${year}`;
}
</script>
<template>
    <LayoutAuthenticated>
        <Head title="Analytic" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiChartBar"
                title="Analytic"
                main
            >
                <BaseButton
                    href="https://github.com/balajidharma/laravel-vue-admin-panel"
                    target="_blank"
                    :icon="mdiGithub"
                    label="Star on GitHub"
                    color="contrast"
                    rounded-full
                    small
                />
                <form>
                    <FormField label="Month">
                        <VueDatePicker
                            v-model="formFilter.tren"
                            placeholder="Filter by Month"
                            month-picker
                            @update:model-value="
                                formFilter.get(route('analytic'))
                            "
                            :format="formatMonth"
                            :max-date="new Date()"
                        >
                        </VueDatePicker>
                    </FormField>
                </form>
            </SectionTitleLineWithButton>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
                <CardBoxWidget
                    color="text-slate-600"
                    :icon="mdiAccountMultiple"
                    :number="totalPerMonth"
                    label="Total Visit Request"
                />
            </div>

            <div>
                <Bar
                    id="trenChart"
                    :options="chartOptions"
                    :data="chartData"
                    v-if="dailyData.length > 0"
                />
                <div
                    v-else
                    class="w-full flex justify-center items-center min-h-[500px] bg-gray-200 rounded-xl"
                >
                    <h1 class="text-2xl font-semibold">No Data to Display</h1>
                </div>
            </div>

            <div class="flex mx-auto w-1/2 mt-10">
                <Pie
                    id="categoryChart"
                    :options="chartOptions2"
                    :data="chartData2"
                />
            </div>
        </SectionMain>
    </LayoutAuthenticated>
</template>
