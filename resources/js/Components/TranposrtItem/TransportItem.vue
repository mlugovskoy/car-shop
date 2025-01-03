<script setup>
import {router, usePage} from "@inertiajs/vue3";
import {reactive, ref} from "vue";

const props = defineProps({
    transport: {
        type: Object,
        required: true
    }
});
const processing = ref(false);
const page = usePage();
const favorites = ref(page.props.favorites);
const favoriteForm = reactive({
    transport_id: ''
});

const isFavorite = (id) => {
    if (favorites.value.hasOwnProperty(id) || page.props.isFavoritePage) {
        return true;
    }
}

const changeFavorite = (id) => {
    processing.value = true;

    if (!favorites.value.hasOwnProperty(id) && !page.props.isFavoritePage) {
        favorites.value[id] = {
            id: id,
            user_id: page.props.auth.user.id,
            transport_id: id
        }

        router.post(route('transport.addFavorite', id), {...favoriteForm}, {
            preserveState: true, preserveScroll: true, onSuccess: () => {
                processing.value = false
            }
        })
    } else {
        delete favorites.value[id]

        router.post(route('transport.removeFavorite', id), {...favoriteForm}, {
            preserveState: true, preserveScroll: true, onSuccess: () => {
                processing.value = false
            }
        })
    }
}
</script>

<template>
    <div
        class="flex flex-col md:flex-row relative group gap-8 rounded-md border-2 border-emerald-400 py-6 px-10 pr-12 transition-colors hover:bg-emerald-400">
        <img v-if="transport.images.length > 0" :src="transport.images[0].image_path" :alt="transport.maker.name"
             class="w-56 object-cover rounded-md">
        <div v-else
             class="border-2 rounded-md border-emerald-400 w-full sm:w-56 h-36 bg-emerald-50 text-sm flex items-center text-center justify-center text-gray-500">
            Изображение<br> отсутствует
        </div>
        <div class="flex flex-col md:flex-row justify-between flex-auto gap-4">
            <div class="flex flex-col flex-auto">
                <h3 class="text-base md:text-xl text-gray-500 font-bold">{{ transport.title }}</h3>
                <span class="text-sm text-gray-400">{{ transport.engine }}</span>
                <span class="text-gray-500 text-sm md:text-base">{{ transport.preview }}</span>
                <span
                    class="hidden sm:block text-gray-500 py-2 text-sm max-w-[500px] w-full">{{
                        transport.description
                    }}</span>
            </div>
            <div class="flex flex-col align-center text-left md:text-center justify-between">
                <div class="font-bold text-gray-500 text-base md:text-xl">
                    {{ transport.price }}
                </div>
                <div class="flex flex-col gap-2">
                    <div class="text-sm text-gray-500">{{ transport.city }}</div>
                    <div class="text-sm text-gray-500">{{ transport.user.name }}</div>
                    <div class="text-sm text-gray-500">{{ transport.published_at }}</div>
                </div>
            </div>
        </div>
        <a :href="route('transport.show', {section: transport.maker.name, id: transport.id})"
           class="absolute z-10 top-0 right-0 left-0 bottom-0 w-full h-full"></a>
        <button v-on:click="changeFavorite(transport.id)"
                :disabled="processing"
                class="absolute top-2 right-2 z-50 opacity-0 transition-all group-hover:opacity-100 group/button">
            <svg
                class="fill-emerald-400 group-hover:fill-white transition-all group-active/button:fill-red-400"
                :class="{'group-hover:!fill-red-400': isFavorite(transport.id)}"
                xmlns="http://www.w3.org/2000/svg"
                height="26px" viewBox="0 -960 960 960"
                width="26px">
                <path
                    d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
            </svg>
        </button>
    </div>
</template>
