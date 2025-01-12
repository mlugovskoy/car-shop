<script setup>

import Dropdown from "@/Components/Dropdown.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    items: {
        type: Object,
        default: null
    },
    itemsCount: {
        type: Number || String
    }
})

const deleteNotifications = () => {
    router.post(route('notifications.destroy'), {
        preserveState: true,
        preserveScroll: true,
    })
}

const readNotifications = (id) => {
    router.post(route('notifications.update', id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            router.reload({only: ['items', 'itemsCount']});
        }
    })
}
</script>

<template>
    <Dropdown align="right" width="72" contentClasses="min-w-72 w-full bg-white">
        <template #trigger>
            <button
                class="fill-emerald-400 mx-2 p-2 rounded-md transition-all hover:bg-emerald-50 relative">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                     width="24px">
                    <path
                        d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z"/>
                </svg>

                <span v-if="itemsCount"
                      class="absolute -top-1 -right-1 bg-emerald-400 w-4 h-4 rounded-md text-xs text-white font-semibold">
                    {{ itemsCount }}
                </span>
            </button>
        </template>
        <template #content>
            <div v-if="items && items.length > 0" class="text-sm p-4">
                <button @click="deleteNotifications" class="block text-xs text-right w-full mb-2 text-red-400">Очистить
                    уведомления
                </button>
                <div v-for="(item, key) in items">
                    <div class="border-2 p-2 mt-2 rounded-md border-gray-100" :key="key">
                        <p v-html="item.data.data"></p>
                        <p class="text-emerald-400 text-right w-full" v-if="item.read_at !== null">прочитано</p>
                        <button v-else @click="readNotifications(item.id)" class="text-right w-full text-gray-200">
                            прочитать
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-sm py-6 px-2 text-center" v-else>Список уведомлений пуст</div>
        </template>
    </Dropdown>
</template>
