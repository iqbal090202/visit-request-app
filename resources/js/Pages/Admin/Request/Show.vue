<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { mdiFileMarker, mdiArrowLeftBoldOutline, mdiDownload } from "@mdi/js";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionMain from "@/Components/SectionMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    roles: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <LayoutAuthenticated>
        <Head title="View Visit Request" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiFileMarker"
                title="View Visit Request"
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
            <CardBox class="mb-6">
                <table>
                    <tbody>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Visit Purpose
                            </td>
                            <td data-label="Visit Purpose">
                                {{ data.visit_purpose }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Start Date
                            </td>
                            <td data-label="Start Date">
                                {{ data.start_date }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                End Date
                            </td>
                            <td data-label="End Date">
                                {{ data.end_date }}
                            </td>
                        </tr>
                        <tr v-if="data.qrcode">
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                QR Code
                            </td>
                            <td data-label="QR Code">
                                <div class="flex flex-col">
                                    <img
                                        :src="'../storage' + data.qrcode"
                                        class="p-2 lg:p-3 bg-white mb-3 w-[200px]"
                                    />
                                    <BaseButton
                                        :href="'../storage' + data.qrcode"
                                        :icon="mdiDownload"
                                        class="lg:w-[120px]"
                                        label="Download"
                                        color="white"
                                        rounded-full
                                        small
                                        download
                                    />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </CardBox>

            <div class="my-3 text-2xl">Visitor Data</div>

            <CardBox
                class="mb-6"
                v-for="visitor in data.visitors"
                :key="visitor.id"
            >
                <table>
                    <tbody>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Visitor Name
                            </td>
                            <td data-label="Name">
                                {{ visitor.name }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Identity Number (KTP / Pasport)
                            </td>
                            <td data-label="KTP / Passport">
                                {{ visitor.ktp }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Company
                            </td>
                            <td data-label="Company">
                                {{ visitor.company }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Occupation
                            </td>
                            <td data-label="Occupation">
                                {{ visitor.occupation }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Email
                            </td>
                            <td data-label="Email">
                                {{ visitor.email }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Phone
                            </td>
                            <td data-label="Phone">
                                {{ visitor.phone }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
