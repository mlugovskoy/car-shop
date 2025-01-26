<script setup>
import {inject} from "vue";

const changeDrawerStatus = inject('changeDrawerStatus');
</script>

<template>
    <div class="flex items-center justify-between mb-4 sm:mb-8">
        <h3 class="text-emerald-400 text-3xl sm:text-4xl inline-block">
            Корзина
        </h3>
        <button @click="changeDrawerStatus">
            <svg class="fill-red-400" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960"
                 width="30px">
                <path
                    d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
            </svg>
        </button>
    </div>
</template>
