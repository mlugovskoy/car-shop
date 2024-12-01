<script setup>

import {ref} from "vue";

const isModalVisible = ref(false);
const emit = defineEmits(['close']);

const showModal = () => {
    isModalVisible.value = true;
}

const closeModal = () => {
    isModalVisible.value = false;
    emit('close');
}
defineExpose({showModal, closeModal});
</script>

<template>
    <transition name="modal">
        <div v-show="isModalVisible"
             class="fixed z-10 top-0 bottom-0 left-0 right-0 bg-slate-900/20 flex justify-center items-center">
            <div class="bg-white w-[800px] rounded shadow overflow-x-auto flex flex-col">
                <header
                    class="p-6 text-2xl flex border-b-2 border-b-emerald-400 text-gray-500 font-bold justify-between">
                    <slot name="header">
                        Шапка по умолчанию
                    </slot>
                    <button
                        type="button"
                        @click="closeModal"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                             class="fill-red-400">
                            <path
                                d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                        </svg>
                    </button>
                </header>
                <section class="relative p-6">
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
