<script setup>

const props = defineProps({'links': Array})

const makeLabel = (label) => {
    if (label.includes('previous')) {
        return "Назад";
    } else if (label.includes('next')) {
        return 'Вперед';
    } else {
        return label;
    }
}
</script>

<template>
    <div v-if="links.length > 3"
         class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-6 sm:px-6">
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-center">
            <div class="isolate inline-flex -space-x-px rounded-md shadow-sm"
                 v-for="link in links" :key="link.url">
                <component :is="link.url ? 'a' : 'span'"
                           :href="link.url"
                           class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold transition-all focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
                           :class="{'bg-emerald-400 text-white': link.active, 'text-zinc-100 cursor-default': !link.url, 'hover:bg-emerald-50': !link.active && link.url}"
                           v-html="makeLabel(link.label)"
                />
            </div>
        </div>
    </div>
</template>
