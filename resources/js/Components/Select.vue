<script setup>
import {ref, watch} from "vue";

const props = defineProps({
    options: {
        type: Array,
        required: true
    },
    placeholder: {
        type: String,
        default: 'Выберите опцию...'
    },
    value: {
        type: String,
        required: true
    },
});

const emit = defineEmits(['input'])
let selectedValue = ref(props.value);

const updateValue = () => {
    emit('input', selectedValue.value)
}

watch(() => props.value, (newValue) => {
    selectedValue.value = newValue;
})
</script>

<template>
    <select
        class="border-2 border-emerald-400 rounded text-gray-500 focus:border-emerald-400 w-full text-sm focus:ring-blue-500 placeholder-emerald-400 block p-2.5"
        name="makers" id="makers" v-model="selectedValue" @change="updateValue">
        <option value="" selected>{{ placeholder }}</option>
        <option v-for="option in options" :key="option.value" :value="option.value">
            {{ option.text }}
        </option>
    </select>
</template>
