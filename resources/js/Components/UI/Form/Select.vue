<script setup>
import {ref, watch} from "vue";

const props = defineProps({
    required: Boolean,
    options: {
        type: Array,
        required: true
    },
    placeholder: {
        type: String,
        default: 'Выберите опцию...'
    },
    name: {
        type: String,
        required: true
    },
    modelValue: {
        type: String,
        required: true
    }
});

const emit = defineEmits(['update:modelValue'])
let selectedValue = ref(props.modelValue);

watch(selectedValue, (newValue) => {
    emit('update:modelValue', selectedValue.value)
});

watch(() => props.modelValue, (newValue) => {
    selectedValue.value = newValue;
})
</script>

<template>
    <select
        class="border-2 border-emerald-400 rounded-md text-gray-500 focus:border-emerald-400 w-full text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
        :name="name" :id="name" v-model="selectedValue" :required="required">
        <option value="" selected>{{ placeholder }}<span v-if="required">*</span></option>
        <option v-for="(option, key) in options" :key="key"
                :value="option.value">
            {{ option.value }}
        </option>
    </select>
</template>
