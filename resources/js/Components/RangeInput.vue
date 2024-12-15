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

const inputValue = ref(props.value);

watch(inputValue, (value_min, value_max) => {
    emit('update:value', value_min, value_max);
});

watch(() => props.value, (value_min, value_max) => {
    inputValue[0].value = value_min;
    inputValue[1].value = value_max;
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
                class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-1/2 text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
                :type="inputType" placeholder="От">
            <input
                v-model="inputValue[1]"
                :name="nameFrom"
                :id="nameFrom"
                class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-1/2 text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
                :type="inputType" placeholder="До">
        </div>
    </div>
</template>
