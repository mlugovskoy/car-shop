<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link class="fill-emerald-400 mx-2 p-2 rounded transition-all hover:bg-emerald-50"
          :href="href">
        <slot/>
    </Link>
</template>
