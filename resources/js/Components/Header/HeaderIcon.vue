<script setup>
import {Link} from '@inertiajs/vue3';
import {computed} from "vue";

const props = defineProps({
    href: {
        type: String,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'fill-emerald-400 bg-emerald-50 mx-2 p-2 rounded-md transition-all cursor-pointer'
        : 'fill-emerald-400 mx-2 p-2 rounded-md transition-all hover:bg-emerald-50 cursor-pointer',
);
</script>

<template>
    <Link v-if="href" :class="classes"
          :href="href">
        <slot/>
    </Link>
    <div v-else :class="classes">
        <slot/>
    </div>
</template>
