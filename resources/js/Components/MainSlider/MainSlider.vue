<script setup>

import {Swiper, SwiperSlide} from "swiper/vue";
import {ref} from "vue";
import 'swiper/css';
import 'swiper/css/navigation';
import {Navigation} from "swiper/modules";

const modules = ref([Navigation]);

const props = defineProps({'transports': Array})

</script>

<template>
    <swiper
        :breakpoints="{1400:{slidesPerView: 6},1000:{slidesPerView:4},600:{slidesPerView:2},0:{slidesPerView: 1}}"
        :space-between="5"
        :navigation="true"
        :loop="true"
        :modules="modules"
        class="h-[300px]">
        <swiper-slide v-for="transport in transports" tag="a" class="group" :href="route('transport.show', {section: transport.maker.name, id: transport.id})">
            <div class="h-3/4 relative">
                <img v-if="transport.images[0]" class="h-full w-full object-cover transition-all group-hover:opacity-85"
                     :src="transport.images[0].image_path"
                     :alt="transport.images[0].image_title">
                <div v-else
                     class="border-2 rounded-md border-emerald-400 mx-auto w-full h-full bg-emerald-50 text-sm flex items-center text-center justify-center text-gray-500">
                    Изображение<br> отсутствует
                </div>
                <span
                    class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">
                    {{ (transport.price).toLocaleString("ru-RU") }} Р</span>
            </div>
            <div class="h-1/4 px-2 flex flex-col justify-center">
                <h4 class="text-xl mb-0.5">{{ transport.makerName + ' ' + transport.modelName }}</h4>
                <span class="text-md">{{ transport.city }}</span>
            </div>
        </swiper-slide>
    </swiper>
</template>

<style>
.swiper-button-prev,
.swiper-button-next {
    color: rgba(52 211 153);
    height: 100%;
    width: 100px;
    top: 0;
    margin-top: 0;
    opacity: 0;
    transition: all .3s;
}

.swiper-button-prev {
    left: -30px;
}

.swiper-button-next {
    right: -30px;
}

.swiper:hover
.swiper-button-next {
    opacity: 1;
    background: linear-gradient(to right, transparent, rgba(52, 211, 153, 0.3) 100%);
    right: -15px;
}

.swiper:hover
.swiper-button-prev {
    opacity: 1;
    left: -15px;
    background: linear-gradient(to left, transparent, rgba(52, 211, 153, 0.3) 100%);
}
</style>
