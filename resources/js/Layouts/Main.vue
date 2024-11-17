<script setup>
import {ref} from 'vue';
import Logo from '@/Components/Header/Logo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import HeaderResponsiveNavLink from '@/Components/Header/HeaderResponsiveNavLink.vue';
import {Link} from '@inertiajs/vue3';
import HeaderIcon from "@/Components/Header/HeaderIcon.vue";
import HeaderSearch from "@/Components/Header/HeaderSearch.vue";
import NavLink from "@/Components/NavLink.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <header
                class="border-b border-gray-100 bg-white"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 gap-4 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('home')">
                                    <Logo
                                        class="block h-9 w-auto fill-emerald-400 text-gray-800"
                                    />
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center w-1/2">
                            <HeaderSearch/>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <HeaderIcon>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                     width="24px">
                                    <path
                                        d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                </svg>
                            </HeaderIcon>
                            <HeaderIcon>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                     width="24px">
                                    <path
                                        d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z"/>
                                </svg>
                            </HeaderIcon>
                            <HeaderIcon :href="route('login')" v-if="$page.props.auth.user === null">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                     width="24px">
                                    <path
                                        d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/>
                                </svg>
                            </HeaderIcon>
                            <!-- Settings Dropdown -->
                            <div v-if="$page.props.auth.user !== null" class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Профиль
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Выйти
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <HeaderResponsiveNavLink :active="route().current('home')
                        || route().current('transports')">
                            Автомобили
                        </HeaderResponsiveNavLink>
                        <HeaderResponsiveNavLink>
                            Запчасти
                        </HeaderResponsiveNavLink>
                        <HeaderResponsiveNavLink>
                            Отзывы
                        </HeaderResponsiveNavLink>
                        <HeaderResponsiveNavLink :href="route('news.index')" :active="route().current('news.index')">
                            Новости
                        </HeaderResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div v-if="$page.props.auth.user !== null"
                         class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800"
                            >
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Профиль
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Выйти
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </header>

            <nav
                class="bg-white shadow overflow-x-auto"
            >
                <div class="mx-auto gap-6 max-w-7xl px-4 py-2 hidden sm:flex sm:px-6 lg:px-8">
                    <NavLink :active="route().current('home')
                    || route().current('transports')">
                        Автомобили
                    </NavLink>
                    <NavLink>
                        Запчасти
                    </NavLink>
                    <NavLink>
                        Отзывы
                    </NavLink>
                    <NavLink :href="route('news.index')" :active="route().current('news.index')">
                        Новости
                    </NavLink>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>

            <footer class="bg-white">
                <div
                    class="mx-auto max-w-7xl px-4 py-6 flex flex-wrap flex-col gap-4 lg:gap-0 sm:flex-row justify-between items-center">
                    <div class="flex">
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('home')">
                                <Logo
                                    class="block h-9 w-auto fill-emerald-400 text-gray-800"
                                />
                            </Link>
                        </div>
                    </div>
                    <nav>
                        <div
                            class="flex flex-wrap flex-col mx-auto gap-6 max-w-7xl px-4 py-2 sm:flex-row sm:px-6 lg:px-8">
                            <NavLink :active="route().current('home')
                                    || route().current('transports')">
                                Автомобили
                            </NavLink>
                            <NavLink>
                                Запчасти
                            </NavLink>
                            <NavLink>
                                Отзывы
                            </NavLink>
                            <NavLink :href="route('news.index')" :active="route().current('news.index')">
                                Новости
                            </NavLink>
                        </div>
                    </nav>
                    <div class="text-sm">© {{ (new Date()).getFullYear() }} CarShop</div>
                </div>
            </footer>
        </div>
    </div>
</template>
