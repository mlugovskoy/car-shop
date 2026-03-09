<script setup>
import {ref, reactive, computed, watch} from 'vue'
import FormField from '@/Components/DynamicForm/Field.vue'
import {router} from "@inertiajs/vue3";
import MainTitle from "@/Components/UI/MainTitle.vue";

const props = defineProps({
    formConfig: {type: Object, required: true},
    formId: {type: String, required: true},
    formDebug: {type: Boolean, default: false}
})

const schema = ref(props.formConfig)
const currentStep = ref(0)
const maxReachedStep = ref(0)
const formData = reactive({})
const fieldErrors = reactive({})
const isLoading = ref(false)
const submitted = ref(false)
const builderMode = ref(false)
const debugMode = ref(props.formDebug)
const builderPreviewStep = ref(0)
const jsonDraft = ref(JSON.stringify(props.formConfig, null, 2))
const jsonError = ref('')

const currentStepData = computed(() => schema.value.steps[currentStep.value] ?? {fields: []})

const isVisible = (field) => {
    if (!field.condition) {
        return true
    }

    const {field: f, operator, value} = field.condition
    const val = formData[f]
    switch (operator) {
        case 'equals':
            return val === value
        case 'not_equals':
            return val !== value
        case 'in':
            return (Array.isArray(value) ? value : [value]).includes(val)
        case 'not_in':
            return !(Array.isArray(value) ? value : [value]).includes(val)
        case 'not_empty':
            return val !== '' && val != null && val !== false
        case 'empty':
            return !val
        default:
            return true
    }
}

const clearErrors = () => {
    Object.keys(fieldErrors).forEach(error => delete fieldErrors[error])
}

const validateCurrentStep = async () => {
    clearErrors()

    return new Promise((resolve) => {
        router.post(
            route('form.validate', {id: props.formId, step: currentStep.value}),
            {formData},
            {
                preserveScroll: true,
                onSuccess: () => resolve(true),
                onError: (errors) => {
                    Object.assign(fieldErrors, errors)
                    resolve(false)
                },
                onFinish: () => isLoading.value = false,
            }
        )
        isLoading.value = true
    })
}

const nextStep = async () => {
    const isSuccess = await validateCurrentStep()
    if (!isSuccess) {
        return
    }

    currentStep.value++
    maxReachedStep.value = Math.max(maxReachedStep.value, currentStep.value)
}

const prevStep = () => {
    clearErrors()
    currentStep.value--
}

const goToStep = (index) => {
    if (index > maxReachedStep.value) {
        return
    }

    clearErrors()
    currentStep.value = index
}

const submitForm = async () => {
    const isSuccess = await validateCurrentStep()
    if (!isSuccess) {
        return
    }

    router.post(
        route('form.submit', {id: props.formId}),
        {formData},
        {
            preserveScroll: true,
            onSuccess: () => submitted.value = true,
            onError: (errors) => {
                Object.values(errors).forEach(error => Object.assign(fieldErrors, error))
            },
            onFinish: () => isLoading.value = false,
        }
    )
    isLoading.value = true
}

function applyJson() {
    jsonError.value = ''
    try {
        schema.value = JSON.parse(jsonDraft.value)
        builderPreviewStep.value = 0
    } catch (error) {
        jsonError.value = `Ошибка JSON: ${error.message}`
    }
}

function loadTemplate(template) {
    jsonDraft.value = JSON.stringify(template.schema, null, 2)
    applyJson()
}

watch(builderMode, view => {
    if (view) {
        jsonDraft.value = JSON.stringify(schema.value, null, 2)
    }
})

const templates = [
    {
        label: 'Заявка на кредит',
        schema: {
            id: 'credit_app', title: 'Заявка на кредит',
            steps: [
                {
                    id: 'personal', title: 'Личные данные', icon: '01',
                    fields: [
                        {id: 'name', type: 'text', label: 'ФИО', placeholder: 'Иванов Иван', validation: ['required']},
                        {
                            id: 'employment', type: 'select', label: 'Занятость', validation: ['required'],
                            options: [
                                {value: 'employed', label: 'Работаю'},
                                {value: 'self', label: 'Самозанятый'},
                                {value: 'retired', label: 'Пенсионер'},
                            ]
                        },
                        {
                            id: 'employer', type: 'text', label: 'Место работы',
                            placeholder: 'ООО «Компания»', validation: ['required'],
                            condition: {field: 'employment', operator: 'equals', value: 'employed'}
                        },
                    ]
                },
                {
                    id: 'credit', title: 'Параметры', icon: '02',
                    fields: [
                        {
                            id: 'amount',
                            type: 'number',
                            label: 'Сумма (₽)',
                            placeholder: '500000',
                            validation: ['required']
                        },
                        {
                            id: 'term', type: 'select', label: 'Срок', validation: ['required'],
                            options: [
                                {value: '12', label: '12 мес.'},
                                {value: '24', label: '24 мес.'},
                                {value: '36', label: '36 мес.'},
                            ]
                        },
                        {
                            id: 'agree',
                            type: 'checkbox',
                            label: '',
                            checkbox_label: 'Согласен на кредитную проверку',
                            validation: ['accepted']
                        },
                    ]
                },
            ]
        }
    },
    {
        label: 'Обратная связь',
        schema: {
            id: 'feedback', title: 'Обратная связь',
            steps: [{
                id: 'main', title: 'Сообщение', icon: '→',
                fields: [
                    {id: 'name', type: 'text', label: 'Имя', placeholder: 'Как вас зовут?', validation: ['required']},
                    {
                        id: 'email',
                        type: 'email',
                        label: 'Email',
                        placeholder: 'your@email.com',
                        validation: ['required', 'email']
                    },
                    {
                        id: 'topic', type: 'radio', label: 'Тема', validation: ['required'],
                        options: [
                            {value: 'support', label: 'Поддержка'},
                            {value: 'sales', label: 'Продажи'},
                            {value: 'other', label: 'Другое'},
                        ]
                    },
                    {
                        id: 'message',
                        type: 'textarea',
                        label: 'Сообщение',
                        placeholder: 'Расскажите подробнее...',
                        rows: 4,
                        validation: ['required']
                    },
                ]
            }]
        }
    },
]
</script>

<template>
    <div class="flex flex-col">
        <div v-if="debugMode" class="sticky top-0 z-50 bg-white border-y p-2 border-gray-200 flex items-center justify-between">
            <div class="flex gap-1">
                <button
                    :class="['px-4 py-1.5 rounded-md text-sm font-medium transition-all border border-transparent', !builderMode
                        ? 'bg-emerald-400 text-white'
                        : 'text-gray-500 hover:text-gray-700 hover:bg-emerald-50']"
                    @click="builderMode = false"
                >
                    Превью
                </button>
                <button
                    :class="['px-4 py-1.5 rounded-md text-sm font-medium transition-all border border-transparent', builderMode
                        ? 'bg-emerald-400 text-white'
                        : 'text-gray-500 hover:text-gray-700 hover:bg-emerald-50']"
                    @click="builderMode = true"
                >
                    Конструктор
                </button>
            </div>
        </div>

        <div v-if="!builderMode" class="flex-1 flex items-start justify-center py-12 px-4">
            <div class="w-full">

                <div class="mb-8">
                    <div class="flex items-baseline justify-between mb-3">
                        <MainTitle tag="h3">{{ schema.title }}</MainTitle>
                        <span class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                            {{ currentStep + 1 }} / {{ schema.steps.length }}
                        </span>
                    </div>

                    <div class="h-0.5 bg-gray-200 rounded-full mb-4 overflow-hidden">
                        <div
                            class="h-full bg-emerald-400 rounded-full transition-all duration-500"
                            :style="{ width: ((currentStep + 1) / schema.steps.length * 100) + '%' }"
                        />
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="(step, index) in schema.steps"
                            :key="step.id"
                            :disabled="index > maxReachedStep"
                            :class="[
                                'flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-medium transition-all',
                                index < currentStep
                                    ? 'border-emerald-300 bg-emerald-100 text-emerald-500'
                                    : index === currentStep
                                        ? 'border-emerald-400 text-emerald-500'
                                        : 'border-gray-200 text-gray-400 cursor-not-allowed opacity-50'
                            ]"
                            @click="goToStep(index)">
                            <span :class="[
                                'font-mono text-xs px-1 rounded',
                                index < currentStep  ? 'bg-emerald-200 text-green-600' :
                                index === currentStep ? 'bg-emerald-100 text-emerald-500' : 'bg-gray-100 text-gray-400'
                            ]">
                                {{ index < currentStep ? '✓' : step.icon }}
                            </span>
                            {{ step.title }}
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-8">
                    <transition name="slide" mode="out-in">
                        <div v-if="!submitted" :key="currentStep" class="flex flex-col gap-5">
                            <template v-for="field in currentStepData.fields" :key="field.id">
                                <transition name="fade-field">
                                    <FormField
                                        v-if="isVisible(field)"
                                        :field="field"
                                        :modelValue="formData[field.id] ?? ''"
                                        :error="fieldErrors[field.id]"
                                        @update:modelValue="formData[field.id] = $event"
                                    />
                                </transition>
                            </template>
                        </div>

                        <div v-else class="flex flex-col items-center text-center py-8 gap-4">
                            Спасибо за заявку! В ближайшее время с вами свяжется менеджер.
                        </div>
                    </transition>

                    <div v-if="!submitted" class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                        <button
                            v-if="currentStep > 0"
                            class="px-5 py-2.5 rounded-xl border border-emerald-200 text-sm font-medium text-emerald-500 hover:bg-emerald-100 transition-all"
                            @click="prevStep"
                        >
                            Назад
                        </button>
                        <div v-else/>

                        <button
                            v-if="currentStep < schema.steps.length - 1"
                            :class="['flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold transition-all text-white',
                isLoading ? 'bg-emerald-400 cursor-not-allowed' : 'bg-emerald-400 hover:bg-emerald-300 active:bg-emerald-600']"
                            :disabled="isLoading"
                            @click="nextStep"
                        >
                            <svg v-if="isLoading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            <span v-else>Далее</span>
                        </button>

                        <button
                            v-else
                            :class="['flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold transition-all text-white',
                isLoading ? 'bg-emerald-400 cursor-not-allowed' : 'bg-emerald-400 hover:bg-emerald-300 active:bg-emerald-600']"
                            :disabled="isLoading"
                            @click="submitForm"
                        >
                            <svg v-if="isLoading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            <span v-else>Отправить</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div v-else class="flex-1 flex overflow-hidden">
            <div class="w-1/2 border-r border-gray-200 flex flex-col p-5 gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono font-semibold text-gray-500 uppercase tracking-widest">
                        JSON-схема
                    </span>
                    <button
                        class="px-3 py-1 bg-emerald-400 hover:bg-emerald-300 text-white text-xs font-mono rounded-md transition-all"
                        @click="applyJson"
                    >
                        Применить
                    </button>
                </div>

                <p v-if="jsonError" class="text-red-500 font-mono text-xs">{{ jsonError }}</p>

                <textarea
                    v-model="jsonDraft"
                    spellcheck="false"
                    class="flex-1 min-h-96 w-full bg-gray-950 text-emerald-300 font-mono text-xs leading-relaxed p-4 rounded-xl outline-none resize-none focus:border-emerald-400 transition-colors"
                />

                <div>
                    <p class="text-xs font-mono font-semibold text-gray-400 uppercase tracking-widest mb-2">
                        Шаблоны (Выберите один из для старта)
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="template in templates"
                            :key="template.label"
                            class="px-3 py-1.5 border border-gray-200 hover:border-emerald-300 hover:text-emerald-600 text-gray-500 text-xs rounded-lg transition-all"
                            @click="loadTemplate(template)"
                        >
                            {{ template.label }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex-1 flex flex-col p-5 gap-5 overflow-y-auto">
                <div>
                    <p class="text-xs font-mono font-semibold text-gray-500 uppercase tracking-widest mb-3">
                        Структура
                    </p>
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="(step, index) in schema.steps"
                            :key="step.id"
                            class="border border-gray-200 rounded-xl overflow-hidden"
                        >
                            <div class="flex items-center gap-2 px-4 py-2.5 bg-gray-50 border-b border-gray-200">
                                <span
                                    class="font-mono text-xs font-bold text-emerald-500 bg-emerald-100 px-1.5 py-0.5 rounded">
                                    {{ index + 1 }}
                                </span>
                                <span class="text-sm font-semibold text-gray-600 flex-1">{{ step.title }}</span>
                                <span class="text-xs text-gray-500 font-mono">{{ step.fields.length }} полей</span>
                            </div>
                            <div
                                v-for="field in step.fields"
                                :key="field.id"
                                class="flex items-center gap-2 px-4 py-2 border-b border-gray-100 last:border-0 text-xs"
                            >
                                <span
                                    class="font-mono text-orange-500 bg-orange-50 px-1.5 py-0.5 rounded min-w-16 text-center">
                                    {{ field.type }}
                                </span>
                                <span class="font-mono text-gray-700 flex-1">{{ field.id }}</span>
                                <span v-if="field.condition" class="text-emerald-500" title="Условное поле">⟳</span>
                                <span v-if="field.validation?.includes('required')"
                                      class="text-red-500 font-bold">*</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-mono font-semibold text-gray-500 uppercase tracking-widest">
                            Превью → шаг {{ builderPreviewStep + 1 }}
                        </p>
                        <div class="flex gap-1">
                            <button
                                class="px-2 py-1 border border-gray-200 rounded text-xs hover:bg-gray-50 transition-all"
                                @click="builderPreviewStep = Math.max(0, builderPreviewStep - 1)"
                            >‹
                            </button>
                            <button
                                class="px-2 py-1 border border-gray-200 rounded text-xs hover:bg-gray-50 transition-all"
                                @click="builderPreviewStep = Math.min(schema.steps.length - 1, builderPreviewStep + 1)"
                            >›
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="field in (schema.steps[builderPreviewStep]?.fields || [])"
                            :key="field.id"
                            class="bg-gray-50 rounded-xl p-3"
                        >
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-xs text-gray-500 uppercase tracking-wide font-medium">
                                    {{ field.label || field.id }}
                                </span>
                                <span
                                    v-if="field.condition"
                                    class="text-xs font-mono text-emerald-500 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded"
                                >
                                    если {{ field.condition.field }} {{
                                        field.condition.operator
                                    }} {{ field.condition.value }}
                                </span>
                            </div>
                            <div
                                class="text-xs font-mono text-gray-500 bg-white border border-gray-200 rounded-lg px-3 py-2">
                                <template v-if="field.type === 'select'">
                                    {{ field.options?.map(o => o.label).join(' / ') }} [select]
                                </template>
                                <template v-else-if="field.type === 'radio'">
                                    {{ field.options?.map(o => o.label).join(' | ') }} [radio]
                                </template>
                                <template v-else-if="field.type === 'checkbox'">
                                    {{ field.checkbox_label }} [checkbox]
                                </template>
                                <template v-else-if="field.type === 'textarea'">
                                    многострочный текст [textarea]
                                </template>
                                <template v-else>
                                    {{ field.placeholder || field.type }}
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
