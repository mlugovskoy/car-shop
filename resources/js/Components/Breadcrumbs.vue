<script setup>
const props = defineProps({'items': Array});

let classes = (items, key) => {
    return items.length > 1 && key !== 0 ? "before:text-gray-400 before:absolute before:content-['/'] before:top-0 before:left-[-11px]" : "";
}
</script>

<template>
    <nav>
        <ul class="flex gap-4">
            <li v-for="(item, key) in items"
                class="relative"
                :class="classes(items, key)">
                <component :is="items.length > 1 && item.url ? 'a' : 'span'"
                           class="text-gray-400 text-md"
                           :href="item.url"
                           :class="{'font-bold': !item.url}">
                    {{ item.title }}
                </component>
            </li>
        </ul>
    </nav>
</template>

<style>
.item::before {
    content: '/';
}
</style>
