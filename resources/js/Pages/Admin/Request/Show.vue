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
                            <td data-label="Name">
                                {{ data.visit_purpose }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                Start Date
                            </td>
                            <td data-label="Email">
                                {{ data.start_date }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                End Date
                            </td>
                            <td data-label="Created">
                                {{ data.end_date }}
                            </td>
                        </tr>
                        <tr v-if="data.qrcode">
                            <td
                                class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block"
                            >
                                QR Code
                            </td>
                            <td data-label="Created">
                                <img
                                    :src="'../storage' + data.qrcode"
                                    class="p-3 bg-white mb-3"
                                />
                                <BaseButton
                                    :href="'../storage' + data.qrcode"
                                    :icon="mdiDownload"
                                    label="Download"
                                    color="white"
                                    rounded-full
                                    small
                                    download
                                />
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
                            <td data-label="Name">
                                {{ visitor.ktp }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
