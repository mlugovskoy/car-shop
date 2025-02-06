<script setup>
defineProps({
    tag: {
        type: String,
        default: 'button'
    }
})
</script>

<template>
    <component :is="tag"
        class="items-center rounded-md border border-transparent bg-emerald-400 px-6 py-2 font-semibold tracking-wider text-white transition duration-150 ease-in-out hover:bg-emerald-300 focus:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 active:bg-emerald-600 disabled:bg-gray-400"
    >
        <slot/>
    </component>
</template>
