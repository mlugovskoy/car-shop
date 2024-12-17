<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Select from "@/Components/Select.vue";
import Radio from "@/Components/Radio.vue";
import RangeInput from "@/Components/RangeInput.vue";
import RangeInputSelect from "@/Components/RangeInputSelect.vue";

const page = usePage();

const radios = page.props.fieldsFilters.steeringWheel;
const makers = page.props.fieldsFilters.makers;
const models = page.props.fieldsFilters.models;
const transmission = page.props.fieldsFilters.transmission;
const drive = page.props.fieldsFilters.drive;
const color = page.props.fieldsFilters.color;
const fuelType = page.props.fieldsFilters.fuelType;
const transportType = page.props.fieldsFilters.transportType;
const year = page.props.fieldsFilters.year;

const form = useForm({
    makers: '',
    models: '',
    transmission: '',
    drive: '',
    color: '',
    fuelType: '',
    transportType: '',
    steeringWheel: '',
    year: [],
    price: []
});

const submit = () => {
    form.post(route('transport.index'), {
        preserveScroll: true,
    })
}

const resetForm = () => {
    form.reset()
};

const resetFilter = () => {
    form.makers = '';
    form.models = '';
    form.transmission = '';
    form.drive = '';
    form.color = '';
    form.fuelType = '';
    form.transportType = '';
    form.year[0] = '';
    form.year[1] = '';
    form.price[0] = '';
    form.price[1] = '';
    form.steeringWheel = '';

    submit();
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
                    <div class="grid grid-cols-4 gap-6 mb-6">
                        <Select v-model="form.makers" :options="makers" name="maker" placeholder="Любая марка"/>
                        <Select v-model="form.models" :options="models" name="model" placeholder="Любая модель"/>
                        <Select v-model="form.transmission" :options="transmission" name="transmission"
                                placeholder="Любая трансмиссия"/>
                        <Select v-model="form.drive" :options="drive" name="drive" placeholder="Любой привод"/>
                        <Select v-model="form.color" :options="color" name="color" placeholder="Любой цвет"/>
                        <Select v-model="form.fuelType" :options="fuelType" name="fuelType"
                                placeholder="Любой бензин"/>
                        <Select v-model="form.transportType" :options="transportType" name="transportType"
                                placeholder="Любой тип транспорта"/>
                    </div>

                    <div class="flex gap-6  my-10">
                        <RangeInputSelect v-model="form.year"
                                          :options="year"
                                          label="Год"
                                          placeholder="qwe"
                                          nameFrom="year.max"
                                          nameTo="year.min"/>
                        <RangeInput v-model:value="form.price"
                                    nameTo="price.min"
                                    nameFrom="price.max"
                                    label="Цена"/>
                    </div>
                    <Radio v-model="form.steeringWheel" name="steeringWheel" label="Руль" :radios="radios"/>

                    <div class="mt-6 flex justify-end items-center gap-10">
                        <div class="flex justify-between items-center gap-6">
                            <div class="text-gray-500">
                                Найдено объявлений: {{ page.props.countTransports }}
                            </div>
                            <button v-if="form.makers
                            || form.models
                            || form.transmission
                            || form.drive
                            || form.color
                            || form.fuelType
                            || form.transportType
                            || form.year[0]
                            || form.year[1]
                            || form.price[0]
                            || form.price[1]
                            || form.steeringWheel"
                                    @click="resetFilter"
                                    :disabled="form.processing"
                                    class="flex gap-2 text-gray-500 transition-all hover:text-emerald-400 group"
                                    :class="{'opacity-50 hover:text-gray-500': form.processing}">
                                <svg class="transition-all group-hover:fill-emerald-400 fill-gray-500"
                                     :class="{'opacity-50 group-hover:fill-gray-500': form.processing}"
                                     xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                     width="24px">
                                    <path
                                        d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                                </svg>
                                Сбросить все
                            </button>
                        </div>
                        <button type="submit"
                                :disabled="form.processing"
                                class="block bg-emerald-400 py-2 px-6 rounded text-white transition-all hover:bg-emerald-300"
                                :class="{'bg-gray-500 hover:bg-gray-500': form.processing}">
                            Показать
                        </button>
                    </div>
                </form>

                <div class="border-t-2 rounded border-t-emerald-400 my-10"></div>
                <div v-if="page.props.transports.length > 0" class="flex flex-col gap-4">
                    <a v-for="transport in page.props.transports" :href="route('transport.show', transport.id)"
                       class="flex gap-8 rounded border-2 border-emerald-400 py-6 px-10 transition-colors hover:bg-emerald-400">
                        <img v-if="transport.images" src="" :alt="transport.maker.name">
                        <div v-else
                             class="border-2 rounded border-emerald-400 w-48 h-48 bg-emerald-50 text-sm flex items-center text-center justify-center text-gray-500">
                            Изображение<br> отсутствует
                        </div>
                        <div class="flex justify-between flex-auto gap-4">
                            <div class="flex flex-col flex-auto">
                                <h3 class="text-xl text-gray-500 font-bold">{{ transport.maker.name }}
                                    {{ transport.model.name }},
                                    {{ transport.year }}</h3>
                                <span class="text-sm text-gray-400">{{ transport.engine }}</span>
                                <span class="text-gray-500">{{ transport.preview }}</span>
                                <span
                                    class="text-gray-500 py-2 text-sm max-w-[500px] w-full">{{ transport.description }}</span>
                            </div>
                            <div class="flex flex-col align-center text-center justify-between">
                                <div class="font-bold text-gray-500 text-xl">
                                    {{ transport.price }}
                                </div>
                                <div class="flex flex-col gap-2">
                                    <div class="text-sm text-gray-500">{{ transport.city }}</div>
                                    <div class="text-sm text-gray-500">{{ transport.user.name }}</div>
                                    <div class="text-sm text-gray-500">{{ transport.published_at }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div v-else class="text-center text-xl text-gray-500">
                    Список объявлений пуст
                </div>
            </div>
        </div>
    </Main>
</template>
