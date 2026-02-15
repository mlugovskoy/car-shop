<script setup>
import {computed} from "vue";

const props = defineProps({
    href: {
        type: String,
        required: false
    },
    tag: {
        type: String,
        default: 'h2',
        validator: (value) => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'].includes(value)
    }
});

const sizeMap = {
    h1: 'text-4xl sm:text-4xl',
    h2: 'text-3xl sm:text-4xl',
    h3: 'text-xl sm:text-lg',
    h4: 'text-lg sm:text-base',
    h5: 'text-base',
    h6: 'text-sm'
}


const sizeClass = computed(() => {
    return sizeMap[props.tag] || 'text-sm'
})

const fullClass = computed(() => {
    return `text-emerald-400 mb-4 sm:mb-8 inline-block border-b-2 border-transparent transition-all hover:border-emerald-400 ${sizeClass.value}`.trim()
})
</script>

<template>
    <component :is="tag" :class="fullClass">
        <a :href="href">
            <slot/>
        </a>
    </component>
</template>
