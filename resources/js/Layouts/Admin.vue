<script setup>

import {Head} from "@inertiajs/vue3";
import Main from "@/Layouts/Main.vue";
import MainTitle from "@/Components/UI/MainTitle.vue";
import NavLink from "@/Components/NavLink.vue";
</script>

<template>
    <div v-if="route().current('admin*')"
         class="sticky top-0 bg-white h-6 z-50 shadow text-red-400 text-center">
        Это страница административного раздела!
    </div>
    <Head title="Администрирование"/>
    <Main>
        <div class="mx-auto pt-12 max-w-7xl px-6 lg:px-8">
            <MainTitle :href="route('admin.index')">Администрирование</MainTitle>
        </div>

        <div class="pb-12">
            <div class="mx-auto flex flex-col lg:flex-row justify-between gap-10 max-w-7xl sm:px-6 lg:px-8">
                <nav
                    class="w-full lg:w-1/6 h-full bg-white space-y-2 space-x-2 overflow-x-auto text-nowrap lg:text-wrap lg:space-x-0 p-4 shadow sm:rounded-lg sm:p-8">
                    <NavLink class="block" :href="route('admin.users')"
                             :active="route().current('admin.users')">
                        Пользователи
                    </NavLink>
                    <NavLink class="block" :href="route('admin.transports')"
                             :active="route().current('admin.transports')">
                        Автомобили
                    </NavLink>
                    <NavLink class="block" :href="route('admin.news')"
                             :active="route().current('admin.news')">
                        Новости
                    </NavLink>
                </nav>
                <div class="w-full lg:w-5/6 bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <slot/>
                </div>
            </div>
        </div>
    </Main>
</template>
