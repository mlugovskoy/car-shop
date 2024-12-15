<script setup>
import {ref, watch} from "vue";
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
let selectedValue = ref(props.modelValue);

watch(selectedValue, (value_min, value_max) => {
    emit('update:modelValue', value_min, value_max);
});

watch(() => props.modelValue, (value_min, value_max) => {
    selectedValue[0].value = value_min;
    selectedValue[1].value = value_max;
});
</script>

<template>
    <div class="relative w-72">
        <label class="absolute -top-6 text-sm text-gray-500">{{ label }}</label>
        <div class="flex gap-4">
            <select
                class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-full text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
                :name="nameTo" :id="nameTo" v-model="selectedValue[0]">
                <option value="" selected>От</option>
                <option v-for="(option, key) in options" :key :value="option.value">
                    {{ option.value }}
                </option>
            </select>
            <select
                class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-full text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
                :name="nameFrom" :id="nameFrom" v-model="selectedValue[1]">
                <option value="" selected>До</option>
                <option v-for="(option, key) in options" :key :value="option.value">
                    {{ option.value }}
                </option>
            </select>
        </div>
    </div>
</template>
