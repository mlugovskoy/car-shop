<script setup>
defineProps({
    value: {
        type: String,
    },
    required: {
        type: Boolean
    }
});
</script>

<template>
    <label class="block text-sm font-medium text-gray-500">
        <span v-if="value">{{ value }}<span class="text-red-500" v-if="required">*</span></span>
        <span v-else><slot/></span>
    </label>
</template>
