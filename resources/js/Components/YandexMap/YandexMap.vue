<script setup>

import {onMounted, ref} from "vue";

const props = defineProps({
    apiKey: {
        type: String,
        required: true
    },
    coords: {
        type: String,
        default: '37.588144, 55.733842'
    },
    zoom: {
        type: String,
        default: 10
    }
});

const mapContainer = ref(null)
const isLoading = ref(true)
const zoom = ref(props.zoom !== null ? props.zoom : 10)

const parseCoords = (str) => {
    if (!str) {
        return [37.588144, 55.733842];
    }

    try {
        const [lng, lat] = str.split(',').map(s => parseFloat(s.trim()));

        if (isFinite(lng) && isFinite(lat)) {
            return [lng, lat];
        }

        console.warn('Используются дефолтные координаты карт')
        return [37.588144, 55.733842];
    } catch (e) {
        console.warn('Используются дефолтные координаты карт')
        return [37.588144, 55.733842]
    }
}

const loadYandexMaps = () => {
    return new Promise((resolve, reject) => {
        const script = document.createElement('script')
        script.src = `https://api-maps.yandex.ru/v3/?apikey=${props.apiKey}&lang=ru_RU`
        script.async = true

        script.onload = () => {
            if (ymaps3?.ready) {
                ymaps3.ready.then(resolve).catch(reject)
            } else {
                reject(new Error('ymaps3 не инициализирован'))
            }
        }

        document.head.appendChild(script)
    });
}

const initMap = async () => {
    await ymaps3.ready;

    const {YMap, YMapDefaultSchemeLayer} = ymaps3;

    const validCoords = parseCoords(props.coords);

    const map = new YMap(mapContainer.value, {
            location: {
                center: validCoords,
                zoom: zoom.value
            }
        }
    );

    map.addChild(new YMapDefaultSchemeLayer())
}

onMounted(async () => {
    try {
        await loadYandexMaps()
        await initMap()
        isLoading.value = false
    } catch (error) {
        console.error('Ошибка загрузки Яндекс Карт:', error)
        isLoading.value = false
    }
})
</script>

<template>
    <div class="relative">
        <div ref="mapContainer" id="yandex_map" class="w-full h-[400px] rounded-lg overflow-hidden border"></div>

        <div v-if="isLoading"
             class="absolute inset-0 flex items-center justify-center bg-gray-50">
            <div class="text-md font-medium leading-5 text-gray-500">Загрузка карты...</div>
        </div>
    </div>
</template>

<style scoped>
</style>
