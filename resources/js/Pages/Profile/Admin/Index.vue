<script setup>

import Admin from "@/Layouts/Admin.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
    <Admin>
        <div v-if="page.props.items && page.props.items.length <= 0"
             class="text-xl flex justify-center items-center h-full">
            Выберите необходимый раздел в меню
            слева
        </div>
    </Admin>
</template>
