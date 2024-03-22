<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
  users: {
    type: Object,
    default: () => ({}),
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
})

// const columns = [
//     { data: "id", title: "ID" },
//     { data: "name", title: "Name" },
//     { data: "email", title: "Email" },
//     {
//         data: null,
//         render: "#action",
//         // render: function(data) {
//         //     return '<button @click="">Delete</button>'
//         // },
//         title: "Action",
//     },
// ];
</script>
<template>
    <Head title="List User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <DataTable :data="datas" :columns="columns">
                            <template #action="props">
                                <SecondaryButton @click="console.log(props)"
                                    ><font-awesome-icon icon="trash"
                                /></SecondaryButton>
                            </template>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
