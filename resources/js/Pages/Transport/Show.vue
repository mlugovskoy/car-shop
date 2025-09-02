<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Breadcrumbs from "@/Components/UI/Breadcrumbs.vue";
import {Swiper, SwiperSlide} from "swiper/vue";
import {reactive, ref} from "vue";
import 'swiper/css';
import 'swiper/css/navigation';
import {Navigation} from "swiper/modules";
import PrimaryButton from "@/Components/UI/PrimaryButton.vue";
import Slider from "@/Components/Slider/Slider.vue";

const page = usePage();
const modules = ref([Navigation]);
const processing = ref(false);
const beforeClassesItem = "before:absolute before:text-gray-400 before:content-[''] before:top-2 before:left-[-20px] before:w-2 before:h-2 before:bg-emerald-400 before:rounded-md";
const favoriteForm = reactive({
    transport_id: ''
});

const changeFavorite = (id) => {
    processing.value = true;

    if (!page.props.isFavorite) {
        router.post(route('transport.addFavorite', id), {...favoriteForm}, {
            preserveState: true, preserveScroll: true, onSuccess: () => {
                processing.value = false
            }
        })
    } else {
        router.post(route('transport.removeFavorite', id), {...favoriteForm}, {
            preserveState: true, preserveScroll: true, onSuccess: () => {
                processing.value = false
            }
        })
    }
}

const addAndDeleteToCart = (item) => {
    if (checkAdded(item)) {
        page.props.cart.items.splice(page.props.cart.items.indexOf(item), 1)
        deleteCartItemToDb(item.id);
    } else {
        page.props.cart.items.push(item);
        addCartItemToDb(item);
    }
}

const checkAdded = (item) => {
    return page.props.cart.items.find(cartItem => cartItem.id === item.id)
}

const addCartItemToDb = (item) => {
    router.post(route('cart.add'), {item}, {
        preserveState: true, preserveScroll: true, onSuccess: () => {
            processing.value = false
        }
    })
}

const deleteCartItemToDb = (id) => {
    router.post(route('cart.delete', id), {}, {
        preserveState: true, preserveScroll: true, onSuccess: () => {
            processing.value = false
        }
    })
}
</script>

<template>
    <Head :title="'Объявление - ' + page.props.transport.maker.name + ' ' + page.props.transport.model.name"/>

    <Main>
        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl mt-10 px-8">
                <Breadcrumbs :items="page.props.breadcrumbs"/>
            </div>
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-4 mb-14 p-6 lg:p-8 sm:rounded-lg">
                <MainTitle :href="route('transport.show', page.props.transport.id)">
                    {{ page.props.transport.maker.name + ' ' + page.props.transport.model.name }}
                </MainTitle>

                <div class="flex gap-8 mb-8">
                    <div class="text-gray-400">{{ page.props.transport.user.name }}</div>
                    <div
                        class="relative text-gray-400"
                        :class="beforeClassesItem">
                        {{ page.props.transport.published_at }}
                    </div>
                </div>

                <div class="mb-14">
                    <div class="flex flex-col lg:flex-row gap-10 justify-between mb-14">
                        <div class="lg:w-3/4">
                            <Slider :items="page.props.transport.images" />
                        </div>
                        <div class="w-full px-0 sm:px-20 lg:px-0 lg:w-1/4">
                            <div class="text-4xl font-bold tracking-wide mb-6">{{ page.props.transport.price }}</div>
                            <div class="flex flex-col gap-y-2">
                                <div v-if="page.props.transport.engine" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Двигатель</span>
                                    <span class="w-1/2">{{ page.props.transport.engine }}</span>
                                </div>
                                <div v-if="page.props.transport.power" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Мощность</span>
                                    <span class="w-1/2">{{ page.props.transport.power }} л.с.</span>
                                </div>
                                <div v-if="page.props.transport.transmission" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Коробка передач</span>
                                    <span class="w-1/2">{{ page.props.transport.transmission }}</span>
                                </div>
                                <div v-if="page.props.transport.drive" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Привод</span>
                                    <span class="w-1/2">{{ page.props.transport.drive }}</span>
                                </div>
                                <div v-if="page.props.transport.mileage" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Пробег</span>
                                    <span class="w-1/2">{{ page.props.transport.mileage }} км</span>
                                </div>
                                <div v-if="page.props.transport.color" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Цвет</span>
                                    <span class="w-1/2">{{ page.props.transport.color }}</span>
                                </div>
                                <div v-if="page.props.transport.steering_wheel" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Руль</span>
                                    <span class="w-1/2">{{ page.props.transport.steering_wheel }}</span>
                                </div>
                                <div v-if="page.props.transport.year" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Год</span>
                                    <span class="w-1/2">{{ page.props.transport.year }}</span>
                                </div>
                                <div v-if="page.props.transport.city" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Город</span>
                                    <span class="w-1/2">{{ page.props.transport.city }}</span>
                                </div>
                                <div v-if="page.props.transport.phone" class="flex justify-between">
                                    <span class="text-gray-400 pr-2 w-1/2">Телефон</span>
                                    <a :href="'tel:' + page.props.transport.phone"
                                       class="w-1/2 text-emerald-400 font-bold hover:text-emerald-300 transition-all">{{
                                            page.props.transport.phone
                                        }}</a>
                                </div>
                                <button v-if="page.props.auth.user !== null"
                                        class="mt-4 text-left text-emerald-400 font-bold hover:text-emerald-300 transition-all"
                                        @click="changeFavorite(page.props.transport.id)"
                                        :disabled="processing">
                                    {{
                                        page.props.isFavorite ? 'Удалить из избранного' : 'Добавить в избранное'
                                    }}
                                </button>
                                <PrimaryButton v-if="page.props.auth.user !== null" class="mt-2"
                                               @click="addAndDeleteToCart(page.props.transport)"
                                               :disabled="processing">
                                    {{ checkAdded(page.props.transport) ? 'Удалить из корзины' : 'Добавить в корзину' }}
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                    <div v-if="page.props.transport.description" class="px-0 sm:px-20 lg:px-0 w-full lg:mb-16">
                        <div
                            class="text-emerald-400 text-2xl sm:text-3xl mb-4 sm:mb-8 inline-block transition-all">
                            Описание
                        </div>
                        <p class="text-gray-500">
                            {{ page.props.transport.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </Main>
</template>
