<script setup>
import { useStyleStore } from "@/Stores/style.js";
import BaseButton from "@/Components/BaseButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { mdiPlus, mdiSend } from "@mdi/js";
import { mdiAlertBoxOutline } from "@mdi/js";
import VisitDetail from "./Admin/Request/partials/VisitDetail.vue";
import VisitorList from "./Admin/Request/partials/VisitorList.vue";
import NotificationBar from "@/Components/NotificationBar.vue";
import LayoutGuest from "@/Layouts/LayoutGuest.vue";
import { reactive, ref } from "vue";

const styleStore = useStyleStore();

const form = useForm({
    visit_purpose: "Survey",
    start_date: new Date(),
    end_date: new Date(),
    description: "haloo",
    spk: null,
    visitors: [],
});

const initialVisitor = {
    ktp: "321391203123",
    name: "ibangg",
    file_ktp: "",
    company: "PT ibang",
    occupation: "CEO",
    phone: "08192381231",
    email: "ias@asd.sad",
    show: true,
};

const terms = ref(false);
const dataVisitors = reactive([initialVisitor]);

const addVisitor = () => {
    dataVisitors.push({
        ktp: "",
        name: "",
        file_ktp: "",
        company: "",
        occupation: "",
        phone: "",
        email: "",
        show: true,
    });
};

const toggleShowVisitor = (index) =>
    (dataVisitors[index].show = !dataVisitors[index].show);

const deleteVisitor = (index) => dataVisitors.splice(index, 1);

const submit = () => {
    form.visitors = dataVisitors;
    form.post(route("form.visit.store"));
};
</script>

<template>
    <LayoutGuest>
        <Head title="Form" />
        <NotificationBar
            :key="Date.now()"
            v-if="$page.props.flash.message"
            :color="
                $page.props.flash.color == null
                    ? 'success'
                    : $page.props.flash.color
            "
            :icon="mdiAlertBoxOutline"
            class="m-5"
        >
            {{ $page.props.flash.message }}
        </NotificationBar>
        <div
            class="relative min-h-screen flex flex-col items-center selection:bg-blue-500 selection:text-white"
        >
            <form
                @submit.prevent="submit"
                class="relative w-full flex flex-col p-8"
            >
                <div class="flex gap-8">
                    <div class="flex flex-col w-full lg:w-50">
                        <div class="border-b border-slate-400 pb-4">
                            <h1 class="text-3xl">Visit Detail</h1>
                        </div>
                        <div class="py-4">
                            <VisitDetail :form="form" />
                        </div>
                    </div>
                    <div class="w-full lg:w-50">
                        <div
                            class="border-b border-slate-400 pb-4 flex justify-between"
                        >
                            <h1 class="text-3xl">Visitor List</h1>
                            <BaseButton
                                @click="addVisitor"
                                :icon="mdiPlus"
                                label="Add Visitor"
                                color="info"
                                rounded
                                small
                            />
                        </div>
                        <div class="py-4 h-screen overflow-auto pr-2">
                            <VisitorList
                                :form="form"
                                :visitors="dataVisitors"
                                @delete="deleteVisitor"
                                @toggleShow="toggleShowVisitor"
                                without-header
                            />
                        </div>
                    </div>
                </div>
                <div class="flex justify-between pt-5 border-t-2 mt-5">
                    <div class="terms-checkbox flex items-center gap-2">
                        <input type="checkbox" v-model="terms" />
                        <span
                            >I have read and accept the Term of Use & Privacy
                            Policy</span
                        >
                    </div>
                    <div>
                        <BaseButton
                            type="submit"
                            :icon="mdiSend"
                            label="Submit"
                            color="info"
                            :disabled="!terms"
                            rounded
                        />
                    </div>
                </div>
            </form>
        </div>
    </LayoutGuest>
</template>
