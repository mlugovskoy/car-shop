<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Select from "@/Components/Select.vue";
import {ref} from "vue";

const page = usePage();
const form = useForm({});

const selectedMakers = ref('');
const selectedModels = ref('');

const makers = [
    {value: 'option1', text: 'op1'}
]
const models = [
    {value: 'option2', text: 'op2'}
]

const resetFilter = () => {
    selectedMakers.value = '';
    selectedModels.value = '';
}
</script>

<template>
    <Head title="Автомобили"/>
    <Main>
        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl mt-10 px-8">
                <Breadcrumbs :items="page.props.breadcrumbs"/>
            </div>
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-4 mb-14 p-6 lg:p-8 sm:rounded-lg">
                <div class="flex justify-between items-center mb-4 sm:mb-8">
                    <MainTitle class="!mb-0 !sm:mb-0" :href="route('transport.index')">Автомобили</MainTitle>
                    <button @click="showModal" v-if="page.props.auth.user !== null"
                            class="h-12 px-6 bg-emerald-400 rounded text-white transition-all hover:bg-emerald-300">
                        Добавить объявление
                    </button>
                </div>
                <form @submit.prevent="submit" enctype="multipart/form-data" method="POST">
                    <div class="grid grid-cols-4 gap-6">
                        <Select v-model="selectedMakers" :options="makers" placeholder="Любая марка" :value="selectedMakers"/>
                        <Select v-model="selectedModels" :options="models" placeholder="Любая модель" :value="selectedModels"/>
                    </div>
                    <div class="mt-6 flex justify-end items-center gap-10">
                        <button v-if="selectedMakers || selectedModels" @click="resetFilter"
                                class="flex gap-2 text-gray-500 transition-all hover:text-emerald-400 group">
                            <svg class="transition-all group-hover:fill-emerald-400 fill-gray-500"
                                 xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                <path
                                    d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                            </svg>
                            Сбросить все
                        </button>
                        <button type="submit"
                                :disabled="form.processing"
                                class="block bg-emerald-400 py-2 px-6 rounded text-white transition-all hover:bg-emerald-300">
                            Показать
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Main>
</template>
