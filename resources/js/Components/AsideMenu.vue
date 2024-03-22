<script setup>
import { reactive, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useLayoutStore } from "@/Stores/layout.js";
//import menu from '@/menu.js'
import AsideMenuLayer from "@/Components/AsideMenuLayer.vue";
import OverlayLayer from "@/Components/OverlayLayer.vue";

// let menu = reactive({});
// menu = computed(() => usePage().props.navigation.menu);
let menu = [
    {
        name: "Dashboard",
        link: "/dashboard",
        enabled: 1,
        weight: 0,
        icon: "M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z",
    },
    // {
    //     name: "Roles",
    //     link: "/roles",
    //     enabled: 1,
    //     weight: 2,
    //     icon: "M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z",
    // },
    {
        name: "Users",
        link: "/user",
        enabled: 1,
        weight: 3,
        icon: "M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z",
    },
];


const layoutStore = useLayoutStore();
</script>

<template>
    <AsideMenuLayer
        v-if="Object.keys(menu).length"
        :menu="menu"
        :class="[
            layoutStore.isAsideMobileExpanded ? 'left-0' : '-left-60 lg:left-0',
            { 'lg:hidden xl:flex': !layoutStore.isAsideLgActive },
        ]"
    />
    <OverlayLayer
        v-show="layoutStore.isAsideLgActive"
        z-index="z-30"
        @overlay-click="layoutStore.isAsideLgActive = false"
    />
</template>
