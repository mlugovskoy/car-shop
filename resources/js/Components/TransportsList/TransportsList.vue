<script setup>

import TransportItem from "@/Components/TranposrtItem/TransportItem.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
    <div v-if="page.props.transports.length > 0" class="flex flex-col gap-4">
        <TransportItem v-for="(transport, index) in page.props.transports"
                       :key="index"
                       :transport="transport"/>
    </div>
    <div v-else class="text-center text-xl text-gray-500">
        {{ page.props.isFavoritePage ? 'Список закладок пуст' : 'Список объявлений пуст'}}
    </div>
</template>
