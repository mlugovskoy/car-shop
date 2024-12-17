<script setup>
import {reactive, ref, watch} from "vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    label: {
        type: String,
        default: 'Выбор'
    },
    options: {
        type: Array,
        required: true
    },
    nameTo: {
        type: String,
        required: true
    },
    nameFrom: {
        type: String,
        required: true
    },
    modelValue: {
        type: Array,
        required: true,
        default: []
    },
});

const emit = defineEmits(['update:modelValue'])
let selectedValue = reactive(['', '']);

watch(selectedValue, (newValue) => {
    emit('update:modelValue', newValue);
});

watch(() => props.modelValue, (newValue) => {
    selectedValue.value = [...newValue];
});
</script>

<template>
    <div class="relative w-full md:w-72">
        <label class="absolute -top-6 text-sm text-gray-500">{{ label }}</label>
        <div class="flex flex-wrap md:flex-nowrap gap-4">
            <select
                class="border-2 w-full md:w-1/2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
                :name="nameTo" :id="nameTo" v-model="selectedValue[0]">
                <option value="" selected>От</option>
                <option v-for="(option, index) in options" :key="index" :value="option.value">
                    {{ option.value }}
                </option>
            </select>
            <select
                class="border-2 w-full md:w-1/2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
                :name="nameFrom" :id="nameFrom" v-model="selectedValue[1]">
                <option value="" selected>До</option>
                <option v-for="(option, index) in options" :key="index" :value="option.value">
                    {{ option.value }}
                </option>
            </select>
        </div>
    </div>
</template>
