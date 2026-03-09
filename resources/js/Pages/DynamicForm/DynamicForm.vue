<script setup>
import {defineProps} from 'vue'
import Form from '@/Components/DynamicForm/Form.vue'

const props = defineProps({
    formConfig: Object,
    formId: String,
})
</script>

<template>
    <Form :formConfig="formConfig" :formId="formId"/>
</template>
