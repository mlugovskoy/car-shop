<script setup>

import {Swiper, SwiperSlide} from "swiper/vue";
import {ref} from "vue";
import 'swiper/css';
import 'swiper/css/navigation';
import {Navigation} from "swiper/modules";

const modules = ref([Navigation]);
</script>

<template>
    <swiper
        :slides-per-view="6"
        :space-between="50"
        :navigation="true"
        :modules="modules"
    >
        <swiper-slide>Slide 1</swiper-slide>
        <swiper-slide>Slide 2</swiper-slide>
        <swiper-slide>Slide 3</swiper-slide>
        <swiper-slide>Slide 3</swiper-slide>
        <swiper-slide>Slide 3</swiper-slide>
        <swiper-slide>Slide 3</swiper-slide>
        <swiper-slide>Slide 3</swiper-slide>
        <swiper-slide>Slide 3</swiper-slide>
    </swiper>
</template>

<style>
.swiper-wrapper {
    height: 300px;
}

.swiper-button-prev,
.swiper-button-next {
    height: 100%;
    width: 50px;
    top: 0;
    margin-top: 0;
    background-color: rgba(0, 0, 0, 0.1);
    
}

.swiper-button-prev {
    left: 0;
}

.swiper-button-next {
    right: 0;
}
</style>
