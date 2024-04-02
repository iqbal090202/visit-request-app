<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { mdiFileMarker, mdiArrowLeftBoldOutline } from "@mdi/js";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionMain from "@/Components/SectionMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import VisitDetail from "./partials/VisitDetail.vue";
import VisitorList from "./partials/VisitorList.vue";
import { reactive } from "vue";

const form = useForm({
    visit_purpose: "Survey",
    start_date: new Date(),
    end_date: new Date(),
    description: "haloo",
    spk: null,
    visitors: []
});

const initialVisitor = {
    ktp: "321391203123",
    name: "ibangg",
    file_ktp: "",
    company: "PT ibang",
    occupation: "CEO",
    phone: "08192381231",
    email: "ias@asd.sad",
};

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
    });
};

const deleteVisitor = (index) => {
    dataVisitors.splice(index, 1);
};

const submit = () => {
    form.visitors = dataVisitors;
    form.post(route("request.store"));
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Add Visit Request" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiFileMarker"
                title="Add Visit Request"
                main
            >
                <BaseButton
                    :route-name="route('request.index')"
                    :icon="mdiArrowLeftBoldOutline"
                    label="Back"
                    color="white"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <CardBox form @submit.prevent="submit">
                <h1 class="flex justify-start text-xl font-semibold mb-5">
                    Visit Detail
                </h1>

                <VisitDetail :form="form" />

                <BaseDivider />

                <VisitorList
                    :form="form"
                    :visitors="dataVisitors"
                    @add="addVisitor"
                    @delete="deleteVisitor"
                />

                <template #footer>
                    <BaseButtons>
                        <BaseButton
                            type="submit"
                            color="info"
                            label="Submit"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        />
                    </BaseButtons>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
