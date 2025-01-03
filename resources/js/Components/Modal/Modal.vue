<script setup>

import {onMounted, onUnmounted, ref, watch} from "vue";
import DangerButton from "@/Components/DangerButton.vue";

const isModalVisible = ref(false);
const emit = defineEmits(['close']);

const showModal = () => {
    isModalVisible.value = true;
}

const closeModal = () => {
    isModalVisible.value = false;
    emit('close');
}

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && isModalVisible.value) {
        closeModal();
    }
};

watch(
    () => isModalVisible.value,
    () => {
        if (isModalVisible.value) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
    },
);

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

defineExpose({showModal, closeModal});
</script>

<template>
    <transition name="modal">
        <div v-show="isModalVisible"
             class="fixed z-10 top-0 bottom-0 left-0 right-0 p-10 bg-slate-900/20 flex justify-center items-center">
            <div class="bg-white w-full sm:w-[800px] max-h-full rounded-md shadow flex flex-col">
                <header
                    class="p-6 text-xl sm:text-2xl flex items-center border-b-2 border-b-emerald-400 text-gray-500 font-bold justify-between">
                    <slot name="header">
                        Шапка по умолчанию
                    </slot>
                    <DangerButton
                        type="button"
                        @click="closeModal"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                             class="fill-white">
                            <path
                                d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                        </svg>
                    </DangerButton>
                </header>
                <section class="relative p-6 overflow-y-auto">
                    <slot name="body">
                        Тело по умолчанию
                    </slot>
                </section>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>
