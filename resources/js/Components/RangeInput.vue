<script setup>
import {reactive, ref, watch} from "vue";

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
    value: {
        type: Array,
        default: []
    },
    inputType: {
        type: String,
        default: 'number'
    }
});

const emit = defineEmits(['update:value']);

const inputValue = reactive([...props.value]);

watch(inputValue, (newValue) => {
    emit('update:value', newValue);
});

watch(() => props.value, (newValue) => {
    inputValue.value = [...newValue];
});
</script>

<template>
    <div class="relative w-72">
        <label class="absolute -top-6 text-sm text-gray-500">{{ label }}</label>
        <div class="flex gap-4">
            <input
                v-model="inputValue[0]"
                :name="nameTo"
                :id="nameTo"
                class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-1/2 text-sm focus:ring-blue-500 placeholder-gray-500 block p-2.5"
                :type="inputType" placeholder="От">
            <input
                v-model="inputValue[1]"
                :name="nameFrom"
                :id="nameFrom"
                class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-1/2 text-sm focus:ring-blue-500 placeholder-gray-500 block p-2.5"
                :type="inputType" placeholder="До">
        </div>
    </div>
</template>
