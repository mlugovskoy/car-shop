<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Breadcrumbs from "@/Components/UI/Breadcrumbs.vue";
import {Swiper, SwiperSlide} from "swiper/vue";
import 'swiper/css';
import 'swiper/css/navigation';
import {Navigation} from "swiper/modules";
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const beforeClassesItem = "before:absolute before:text-gray-400 before:content-[''] before:top-2 before:left-[-20px] before:w-2 before:h-2 before:bg-emerald-400 before:rounded-md";
const modules = ref([Navigation]);
const page = usePage();
const form = useForm({
    description: null
})

const submit = () => {
    form.post(`${page.props.article.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('description')
        }
    })
}
</script>

<template>
    <Head :title="'Статья - ' + page.props.article.title"/>

    <Main>
        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl mt-10 px-8">
                <Breadcrumbs :items="page.props.breadcrumbs"/>
            </div>
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-4 mb-14 p-6 lg:p-8 sm:rounded-lg">
                <MainTitle :href="route('news.show', page.props.article.id)">{{ page.props.article.title }}</MainTitle>

                <div class="flex gap-8 mb-8">
                    <div class="text-gray-400">{{ page.props.article.userName }}</div>
                    <div
                        class="relative text-gray-400"
                        :class="beforeClassesItem">
                        {{ page.props.article.published_at }}
                    </div>
                </div>

                <div class="mb-14">
                    <swiper v-if="page.props.article.images.length > 1"
                            :breakpoints="{1400:{slidesPerView: 1}}"
                            :navigation="true"
                            :modules="modules"
                            class="h-[300px] sm:h-[500px] lg:w-3/4 rounded-md">
                        <swiper-slide v-if="page.props.article.images"
                                      v-for="image in page.props.article.images"
                                      class="object-cover"
                                      tag="img"
                                      :src="image.image_path"
                                      :alt="page.props.article.title"/>
                    </swiper>
                    <div v-else>
                        <img class="mx-auto" v-if="page.props.article.images[0]" :src="page.props.article.images[0].image_path"
                             :alt="page.props.article.title">
                    </div>
                </div>

                <div class="mb-14">
                    {{ page.props.article.description }}
                </div>

                <div>
                    <h4 class="text-emerald-400 text-xl sm:text-2xl mb-4 sm:mb-8 inline-block transition-all">
                        Комментарии
                    </h4>
                    <div class="flex flex-col gap-y-8 mb-10">
                        <div v-for="comment in page.props.article.comments"
                             class="flex gap-10">
                            <div class="flex flex-col items-center max-w-24 w-full text-center">
                                <span class="block text-xs mb-2">{{ comment.published_at }}</span>
                                <img class="w-16 h-16 rounded-md mb-2 object-cover" :src="comment.userImage[0].image_path"
                                     :alt="comment.user.name">
                                <h5>{{ comment.user.name }}</h5>
                                <span class="text-xs">{{ comment.city }}</span>
                            </div>
                            <div class="py-4">
                                {{ comment.description }}
                            </div>
                        </div>
                    </div>
                    <div v-if="page.props.auth.user === null" class="text-center">
                        <Link :href="route('login')" class="text-emerald-400 transition-all hover:text-emerald-300">
                            Войдите
                        </Link>
                        или
                        <Link :href="route('register')" class="text-emerald-400 transition-all hover:text-emerald-300">
                            зарегистрируйтесь
                        </Link>
                        , чтобы оставить комментарий
                    </div>
                    <div v-else>
                        <form @submit.prevent="submit" enctype="multipart/form-data" method="POST">
                            <textarea class="block w-full !h-20 rounded-md p-4 border border-emerald-400 resize-none mb-2"
                                      placeholder="Введите сообщение"
                                      v-model="form.description"
                                      id="description"
                                      name="description"></textarea>
                            <div class="text-sm text-red-400 mb-2" v-if="form.errors.description">
                                {{ form.errors.description }}
                            </div>
                            <PrimaryButton type="submit"
                                    :disabled="form.processing"
                                    class="ml-auto block bg-emerald-400 py-2 px-6 rounded-md text-white transition-all hover:bg-emerald-300">
                                Отправить
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Main>
</template>

<style>
.swiper-button-prev,
.swiper-button-next {
    color: rgba(52 211 153);
    height: 100%;
    width: 100px;
    top: 0;
    margin-top: 0;
    opacity: 0;
    transition: all .3s;
}

.swiper-button-prev {
    left: -30px;
}

.swiper-button-next {
    right: -30px;
}

.swiper:hover
.swiper-button-next {
    opacity: 1;
    background: linear-gradient(to right, transparent, rgba(52, 211, 153, 0.3) 100%);
    right: -15px;
}

.swiper:hover
.swiper-button-prev {
    opacity: 1;
    left: -15px;
    background: linear-gradient(to left, transparent, rgba(52, 211, 153, 0.3) 100%);
}
</style>
