<script setup>
import {computed} from 'vue'
import InputError from "@/Components/UI/Form/InputError.vue";
import Checkbox from "@/Components/UI/Form/Checkbox.vue";
import TextInput from "@/Components/UI/Form/TextInput.vue";

const props = defineProps({
    field: {type: Object, required: true},
    modelValue: {default: ''},
    error: {default: null},
})

defineEmits(['update:modelValue'])

const label = computed(() => props.field.label)
const isRequired = computed(() => props.field.validation?.includes('required'))
const isSimpleInput = computed(() =>
    ['text', 'email', 'number', 'date', 'password', 'tel'].includes(props.field.type)
)
</script>

<template>
    <div :class="['ff-group', { 'ff-error': !!error }]">
        <label v-if="label" class="ff-label">
            {{ label }}
            <span v-if="isRequired" class="ff-required">*</span>
        </label>

        <!-- text / email / number / date / password -->
        <TextInput
            v-if="isSimpleInput"
            :type="field.type"
            :placeholder="field.placeholder"
            :modelValue="modelValue"
            @update:modelValue="$emit('update:modelValue', $event)"
        />

        <!-- textarea -->
        <textarea
            v-else-if="field.type === 'textarea'"
            :placeholder="field.placeholder"
            :rows="field.rows || 4"
            :value="modelValue"
            class="w-full px-3 py-2.5 bg-white border-2 border-emerald-400 rounded-md text-sm text-gray-500 outline-none transition-all focus:border-blue-400 focus:ring-2 focus:ring-blue-100 resize-none"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <!-- select -->
        <div v-else-if="field.type === 'select'" class="relative">
            <select
                :value="modelValue"
                class="w-full px-3 py-2.5 bg-white border-2 border-emerald-400 rounded-md text-sm text-gray-500 appearance-none outline-none transition-all focus:border-blue-400 focus:ring-2 focus:ring-blue-100 cursor-pointer"
                @change="$emit('update:modelValue', $event.target.value)"
            >
                <option value="">{{ field.placeholder || 'Выберите...' }}</option>
                <option v-for="opt in field.options" :key="opt.value" :value="opt.value">
                    {{ opt.label }}
                </option>
            </select>
        </div>

        <!-- radio -->
        <div v-else-if="field.type === 'radio'" class="flex flex-wrap gap-2">
            <div
                v-for="opt in field.options"
                :key="opt.value"
                class="flex items-center p-2"
            >
                <input
                    :id="field.id + opt.value"
                    type="radio"
                    :name="field.id"
                    :value="opt.value"
                    :checked="modelValue === opt.value"
                    @change="$emit('update:modelValue', opt.value)"
                    class="w-4 h-4 text-emerald-600 bg-emerald-100 border-emerald-300 focus:ring-emerald-500 focus:ring-2"
                />
                <label
                    :for="field.id + opt.value"
                    class="ms-2 text-sm font-medium text-gray-500"
                >
                    {{ opt.label }}
                </label>
            </div>
        </div>

        <!-- checkbox -->
        <Checkbox v-else-if="field.type === 'checkbox'"
                  :checked="!!modelValue"
                  @update:checked="$emit('update:modelValue', $event ? '1' : '')">
            {{ field.checkbox_label }}
        </Checkbox>

        <transition name="err">
            <InputError v-if="error" :message="Array.isArray(error) ? error[0] : error" class="mt-2"/>
        </transition>
    </div>
</template>
