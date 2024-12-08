<script setup>
import {ref, watch} from "vue";

const props = defineProps({
    label: {
        type: String,
        default: 'Выбор'
    },
    nameTo: {
        type: String,
        required: true
    },
    nameFrom: {
        type: String,
        required: true
    },
    modelValueOne: {
        type: Number || String,
        default: 0
    },
    modelValueTwo: {
        type: Number || String,
        default: 0
    },
    inputType: {
        type: String,
        default: 'number'
    }
});

const emit = defineEmits(['update:modelValueOne', 'update:modelValueTwo']);

const valueInputOne = ref(props.modelValueOne);
const valueInputTwo = ref(props.modelValueTwo);

watch(valueInputOne, (newValue) => {
    emit('update:modelValueOne', newValue);
});

watch(valueInputTwo, (newValue) => {
    emit('update:modelValueTwo', newValue);
});

watch(() => props.modelValueOne, (newValue) => {
    valueInputOne.value = newValue;
});

watch(() => props.modelValueTwo, (newValue) => {
    valueInputTwo.value = newValue;
});
</script>

<template>
    <div class="relative w-72">
        <label class="absolute -top-6 text-sm text-gray-500">{{ label }}</label>
        <div class="flex gap-4">
            <input
                v-model="valueInputOne"
                :name="nameTo"
                :id="nameTo"
                class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-1/2 text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
                :type="inputType" placeholder="От">
            <input
                v-model="valueInputTwo"
                :name="nameFrom"
                :id="nameFrom"
                class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-1/2 text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
                :type="inputType" placeholder="До">
        </div>
    </div>
</template>
