<script setup>
import {defineProps} from 'vue'
import Form from '@/Components/DynamicForm/Form.vue'

const props = defineProps({
    formConfig: Object,
    formId: String,
    formDebug: Boolean
})
</script>

<template>
    <Form :formConfig="formConfig" :formId="formId" :formDebug="formDebug"/>
</template>
