<script setup>

import {Swiper, SwiperSlide} from "swiper/vue";
import {ref} from "vue";
import {Navigation} from "swiper/modules";
import 'swiper/css';
import 'swiper/css/navigation';

const props = defineProps({'items': Array});

const modules = ref([Navigation]);
</script>

<template>
    <swiper v-if="props.items.length > 0" :breakpoints="{1400:{slidesPerView: 1}}"
            :navigation="true"
            :modules="modules"
            class="h-[300px] sm:h-[500px] lg:w-3/4 rounded-md">
        <swiper-slide
            v-for="image in props.items"
            class="object-cover"
            tag="img"
            :src="image.image_path"
            :alt="image.alt_title"/>
    </swiper>
    <div v-else
         class="border-2 rounded-md border-emerald-400 w-full min-h-80 bg-emerald-50 text-sm flex items-center text-center justify-center text-gray-500">
        Изображения<br> отсутствуют
    </div>
</template>

<style>
.swiper-button-prev,
.swiper-button-next {
    color: rgba(52 211 153);
    height: 100%;
    width: 100px;
    top: 0;
    margin-top: 0;
    opacity: 0 !important;
    transition: all .3s;
}

.swiper-button-prev {
    left: -30px;
}

.swiper-button-next {
    right: -30px;
}

.swiper:hover .swiper-button-next {
    opacity: 1 !important;
    background: linear-gradient(to right, transparent, rgba(52, 211, 153, 0.3) 100%);
    right: -15px;
}

.swiper:hover .swiper-button-prev {
    opacity: 1 !important;
    left: -15px;
    background: linear-gradient(to left, transparent, rgba(52, 211, 153, 0.3) 100%);
}

.swiper:hover .swiper-button-disabled {
    display: none;
}
</style>
