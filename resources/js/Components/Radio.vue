<script setup>
import {ref, watch} from "vue";

const props = defineProps({
    label: {
        type: String,
        default: 'Выбор'
    },
    name: {
        type: String,
        required: true
    },
    radios: {
        type: Array,
        default: () => []
    },
    modelValue: {
        type: String,
        required: true
    },
});

const emit = defineEmits(['update:modelValue'])
let selectedValue = ref(props.modelValue);

const updateValue = () => {
    emit('update:modelValue', selectedValue.value)
}

watch(() => props.modelValue, (newValue) => {
    selectedValue.value = newValue;
})
</script>

<template>
    <div class="flex flex-wrap relative my-10">
        <label class="absolute -top-6 text-sm text-gray-500">{{ label }}</label>
        <div class="flex items-center p-2 me-4">
            <input checked :id="name" type="radio" value="" v-model="selectedValue" @change="updateValue"
                   :name="name"
                   class="w-4 h-4 text-emerald-600 bg-emerald-100 border-emerald-300 focus:ring-emerald-500 focus:ring-2">
            <label :for="name"
                   class="ms-2 text-sm font-medium text-gray-500">Любой</label>
        </div>
        <div class="flex items-center p-2 me-4" v-for="(radio, index) in radios" :key="index">
            <input :id="name + index" type="radio" :value="radio" v-model="selectedValue" @change="updateValue"
                   :name="name"
                   class="w-4 h-4 text-emerald-600 bg-emerald-100 border-emerald-300 focus:ring-emerald-500 focus:ring-2">
            <label :for="name + index"
                   class="ms-2 text-sm font-medium text-gray-500">{{ radio }}</label>
        </div>
    </div>
</template>
