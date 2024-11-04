<script setup>
const props = defineProps({
    href: {
        type: String,
        required: true,
    }
});
</script>

<template>
    <h2 class="text-emerald-400 text-3xl sm:text-4xl mb-4 sm:mb-8 inline-block border-b-2 border-transparent transition-all hover:border-emerald-400">
        <a :href="href">
            <slot/>
        </a>
    </h2>
</template>
