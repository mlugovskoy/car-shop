<script setup>
const props = defineProps({
    label: {
        type: String,
        default: 'Выбор'
    },
    radios: {
        type: Array
    }
});
</script>

<template>
    <div class="flex relative">
        <label class="absolute -top-6 text-sm text-gray-500">{{ label }}</label>
        <div class="flex items-center p-2 me-4">
            <input checked id="radio_default" type="radio" value="" name="radio_group"
                   class="w-4 h-4 text-emerald-600 bg-emerald-100 border-emerald-300 focus:ring-emerald-500 focus:ring-2">
            <label for="radio_default"
                   class="ms-2 text-sm font-medium text-gray-500">Любой</label>
        </div>
        <div class="flex items-center me-4" v-for="(radio, index) in radios">
            <input :id="'radio_' + index" type="radio" :value="radio" name="radio_group"
                   class="w-4 h-4 text-emerald-600 bg-emerald-100 border-emerald-300 focus:ring-emerald-500 focus:ring-2">
            <label :for="'radio_' + index"
                   class="ms-2 text-sm font-medium text-gray-500">{{ radio }}</label>
        </div>
    </div>
</template>
