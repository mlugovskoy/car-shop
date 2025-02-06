<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Pagination from "@/Components/Pagination.vue";
import Breadcrumbs from "@/Components/UI/Breadcrumbs.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import PrimaryButton from "@/Components/UI/PrimaryButton.vue";
import FlashMessage from "@/Components/FlashMessage/FlashMessage.vue";
import DangerButton from "@/Components/UI/DangerButton.vue";

const createdModal = ref(false);
const fileInput = ref(null);
const page = usePage();

const news = page.props.news;

const form = useForm({
    title: null,
    description: null,
    images: null,
})

const submit = () => {
    form.post(route('news.store'), {
        preserveScroll: true,
        onSuccess: () => {
           closeModal();
        }
    })
}

const resetForm = () => {
    form.reset('title', 'description');
    form.images = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const confirmUserDeletion = () => {
    createdModal.value = true;
};

const closeModal = () => {
    createdModal.value = false;

    resetForm()
};
</script>

<template>
    <Head title="Новости"/>
    <Main>
        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl mt-10 px-8">
                <Breadcrumbs :items="page.props.breadcrumbs"/>
            </div>
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-4 mb-14 p-6 lg:p-8 sm:rounded-lg">
                <div class="flex justify-between items-center mb-4 sm:mb-8">
                    <MainTitle class="!mb-0 !sm:mb-0" :href="route('news.index')">Новости</MainTitle>
                    <PrimaryButton @click="confirmUserDeletion" v-if="page.props.auth.user !== null">
                        Добавить новость
                    </PrimaryButton>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <a v-for="article in news.data" :href="route('news.show', article.id)"
                       class="rounded-md shadow group">
                        <img v-if="article.images[0]"
                             class="w-full h-[300px] object-cover rounded-t-md transition-all group-hover:opacity-85"
                             :src="article.images[0].image_path"
                             :alt="article.images[0].image_title">
                        <div class="rounded-b-md p-4">
                            <h4 class="text-xl mb-2">{{ article.title }}</h4>
                            <div class="mb-4 text-gray-500">
                                {{ article.description.slice(0, 100) + '...' }}
                            </div>
                            <div class="flex justify-between">
                                <div class="flex gap-2">
                                    <svg class="fill-emerald-400" xmlns="http://www.w3.org/2000/svg" height="24px"
                                         viewBox="0 -960 960 960" width="24px">
                                        <path
                                            d="M80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/>
                                    </svg>
                                    <span>{{ article.comments.length }}</span>
                                </div>
                                <div>
                                    {{ article.published_at }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <Pagination :links="news.meta.links"/>
            </div>
        </div>
    </Main>
    <Modal :show="createdModal" @close="closeModal">
        <header
            class="p-6 text-xl sm:text-2xl flex items-center border-b-2 border-b-emerald-400 text-gray-500 font-bold justify-between">
            Добавление новости
            <DangerButton
                type="button"
                @click="closeModal"
            >
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                     class="fill-white">
                    <path
                        d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                </svg>
            </DangerButton>
        </header>
        <form class="p-6" @submit.prevent="submit" enctype="multipart/form-data" method="POST">
            <input class="block w-full rounded-md p-4 border border-emerald-400 mb-2"
                   type="text"
                   id="title"
                   name="title"
                   placeholder="Заголовок"
                   v-model="form.title">
            <div class="text-sm text-red-400 mb-2" v-if="form.errors.title">{{ form.errors.title }}</div>
            <textarea class="block w-full !h-20 rounded-md p-4 border border-emerald-400 resize-none mb-2"
                      id="description"
                      name="description"
                      placeholder="Описание"
                      v-model="form.description"></textarea>
            <div class="text-sm text-red-400 mb-2" v-if="form.errors.description">
                {{ form.errors.description }}
            </div>
            <label>
                <input
                    ref="fileInput"
                    class="text-sm text-grey-500
                                file:transition-all
                                file:mr-2 file:py-2 file:px-6
                                file:rounded-md file:border-0
                                file:text-sm
                                file:bg-emerald-400 file:text-white
                                hover:file:cursor-pointer hover:file:bg-emerald-500"
                    type="file" id="images" name="images" multiple
                    @change="form.images = $event.target.files">
            </label>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>
            <PrimaryButton type="submit"
                           :disabled="form.processing"
                           class="ml-auto mt-6 block bg-emerald-400 py-2 px-6 rounded-md text-white transition-all hover:bg-emerald-300">
                Добавить
            </PrimaryButton>
        </form>
    </Modal>
    <FlashMessage v-if="page.props.flash.success" :key="page.props.flash.success" :message="page.props.flash.success"/>
</template>
