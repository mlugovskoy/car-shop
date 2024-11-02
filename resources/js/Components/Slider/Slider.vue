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
        :space-between="5"
        :navigation="true"
        :loop="true"
        :modules="modules"
    >
        <swiper-slide>
            <a href="#" class="transition-all hover:opacity-95">
                <div class="h-3/4 relative">
                    <img class="h-full w-full object-cover" src="/images/car.jpg" alt="car">
                    <span
                        class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">4 500 000 Р</span>
                </div>
                <div class="h-1/4 px-2 flex flex-col justify-center">
                    <h4 class="text-xl mb-0.5">BMW X8</h4>
                    <span class="text-md">Благовещенск</span>
                </div>
            </a>
        </swiper-slide>
        <swiper-slide>
            <a href="#" class="transition-all hover:opacity-95">
                <div class="h-3/4 relative">
                    <img class="h-full w-full object-cover" src="/images/car.jpg" alt="car">
                    <span
                        class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">4 500 000 Р</span>
                </div>
                <div class="h-1/4 px-2 flex flex-col justify-center">
                    <h4 class="text-xl mb-0.5">BMW X8</h4>
                    <span class="text-md">Благовещенск</span>
                </div>
            </a>
        </swiper-slide>
        <swiper-slide>
            <a href="#" class="transition-all hover:opacity-95">
                <div class="h-3/4 relative">
                    <img class="h-full w-full object-cover" src="/images/car.jpg" alt="car">
                    <span
                        class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">4 500 000 Р</span>
                </div>
                <div class="h-1/4 px-2 flex flex-col justify-center">
                    <h4 class="text-xl mb-0.5">BMW X8</h4>
                    <span class="text-md">Благовещенск</span>
                </div>
            </a>
        </swiper-slide>
        <swiper-slide>
            <a href="#" class="transition-all hover:opacity-95">
                <div class="h-3/4 relative">
                    <img class="h-full w-full object-cover" src="/images/car.jpg" alt="car">
                    <span
                        class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">4 500 000 Р</span>
                </div>
                <div class="h-1/4 px-2 flex flex-col justify-center">
                    <h4 class="text-xl mb-0.5">BMW X8</h4>
                    <span class="text-md">Благовещенск</span>
                </div>
            </a>
        </swiper-slide>
        <swiper-slide>
            <a href="#" class="transition-all hover:opacity-95">
                <div class="h-3/4 relative">
                    <img class="h-full w-full object-cover" src="/images/car.jpg" alt="car">
                    <span
                        class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">4 500 000 Р</span>
                </div>
                <div class="h-1/4 px-2 flex flex-col justify-center">
                    <h4 class="text-xl mb-0.5">BMW X8</h4>
                    <span class="text-md">Благовещенск</span>
                </div>
            </a>
        </swiper-slide>
        <swiper-slide>
            <a href="#" class="transition-all hover:opacity-95">
                <div class="h-3/4 relative">
                    <img class="h-full w-full object-cover" src="/images/car.jpg" alt="car">
                    <span
                        class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">4 500 000 Р</span>
                </div>
                <div class="h-1/4 px-2 flex flex-col justify-center">
                    <h4 class="text-xl mb-0.5">BMW X8</h4>
                    <span class="text-md">Благовещенск</span>
                </div>
            </a>
        </swiper-slide>
        <swiper-slide>
            <a href="#" class="transition-all hover:opacity-95">
                <div class="h-3/4 relative">
                    <img class="h-full w-full object-cover" src="/images/car.jpg" alt="car">
                    <span
                        class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">4 500 000 Р</span>
                </div>
                <div class="h-1/4 px-2 flex flex-col justify-center">
                    <h4 class="text-xl mb-0.5">BMW X8</h4>
                    <span class="text-md">Благовещенск</span>
                </div>
            </a>
        </swiper-slide>
        <swiper-slide>
            <a href="#" class="transition-all hover:opacity-95">
                <div class="h-3/4 relative">
                    <img class="h-full w-full object-cover" src="/images/car.jpg" alt="car">
                    <span
                        class="absolute bottom-4 left-4 bg-emerald-400 px-2 rounded-xl text-white text-sm">4 500 000 Р</span>
                </div>
                <div class="h-1/4 px-2 flex flex-col justify-center">
                    <h4 class="text-xl mb-0.5">BMW X8</h4>
                    <span class="text-md">Благовещенск</span>
                </div>
            </a>
        </swiper-slide>
    </swiper>
</template>

<style>
.swiper-wrapper {
    height: 300px;
}

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
