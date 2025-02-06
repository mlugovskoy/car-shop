<script setup>
import {onMounted, ref} from "vue";

defineProps({
    message: {
        type: String,
        required: true
    }
})

const visible = ref(true);

const close = () => {
    visible.value = false;
}

onMounted(() => {
    setTimeout(() => {
        visible.value = false;
    }, 5000)
})
</script>

<template>
    <div v-if="visible"
         class="bg-white border-2 border-emerald-400 py-6 px-10 z-50 rounded-md absolute top-10 right-5 text-sm">
        <div class="relative">
            <h5 class="font-semibold tracking-wider mb-2">Уведомление</h5>
            <button @click="close" class="absolute -top-4 -right-8">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"
                     class="fill-red-400">
                    <path
                        d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                </svg>
            </button>
            <p v-html="message"></p>
        </div>
    </div>
</template>
