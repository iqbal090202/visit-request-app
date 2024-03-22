<script setup>
import { Head } from "@inertiajs/vue3";
import {
    mdiChartTimelineVariant,
    mdiGithub,
} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import BaseButton from "@/Components/BaseButton.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Dashboard" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiChartTimelineVariant"
                title="Overview"
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
            </SectionTitleLineWithButton>
        </SectionMain>
    </LayoutAuthenticated>
</template>
