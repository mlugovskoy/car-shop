<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Select from "@/Components/Select.vue";
import Radio from "@/Components/Radio.vue";
import RangeInput from "@/Components/RangeInput.vue";
import RangeInputSelect from "@/Components/RangeInputSelect.vue";
import {onMounted, reactive, ref} from "vue";
import TransportItem from "@/Components/TranposrtItem/TransportItem.vue";
import TransportsList from "@/Components/TransportsList/TransportsList.vue";

const page = usePage();
const processing = ref(false);

const radios = page.props.fieldsFilters.steeringWheel;
const makers = page.props.fieldsFilters.makers;
const models = page.props.fieldsFilters.models;
const transmission = page.props.fieldsFilters.transmission;
const drive = page.props.fieldsFilters.drive;
const color = page.props.fieldsFilters.color;
const fuelType = page.props.fieldsFilters.fuelType;
const transportType = page.props.fieldsFilters.transportType;
const year = page.props.fieldsFilters.year;

const filter = reactive({
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

onMounted(() => {
    let pathname = (window.location.pathname).split('/');
    if (pathname.length > 2) {
        filter.makers = pathname[2].toLowerCase()
    }
})

const submit = () => {
    processing.value = true;
    router.get(route('transport.index'), {...filter}, {
        preserveState: true, preserveScroll: true, onSuccess: () => {
            processing.value = false
        }
    })
}

const resetFilter = () => {
    filter.makers = '';
    filter.models = '';
    filter.transmission = '';
    filter.drive = '';
    filter.color = '';
    filter.fuelType = '';
    filter.transportType = '';
    filter.year[0] = '';
    filter.year[1] = '';
    filter.price[0] = '';
    filter.price[1] = '';
    filter.steeringWheel = '';

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
                <div class="flex flex-wrap gap-y-2 justify-between items-center mb-4 sm:mb-8">
                    <MainTitle class="!mb-0 !sm:mb-0" :href="route('transport.index')">Автомобили</MainTitle>
                    <button @click="showModal" v-if="page.props.auth.user !== null"
                            class="h-12 px-6 bg-emerald-400 rounded text-white transition-all hover:bg-emerald-300">
                        Добавить объявление
                    </button>
                </div>
                <div class="flex flex-col md:grid md:grid-cols-4 gap-6 mb-6">
                    <Select v-model="filter.makers" :options="makers" name="maker" placeholder="Любая марка"/>
                    <Select v-model="filter.models" :options="models" name="model" placeholder="Любая модель"/>
                    <Select v-model="filter.transmission" :options="transmission" name="transmission"
                            placeholder="Любая трансмиссия"/>
                    <Select v-model="filter.drive" :options="drive" name="drive" placeholder="Любой привод"/>
                    <Select v-model="filter.color" :options="color" name="color" placeholder="Любой цвет"/>
                    <Select v-model="filter.fuelType" :options="fuelType" name="fuelType"
                            placeholder="Любой бензин"/>
                    <Select v-model="filter.transportType" :options="transportType" name="transportType"
                            placeholder="Любой тип транспорта"/>
                </div>

                <div class="flex flex-col gap-y-10 md:flex-row gap-6 my-10">
                    <RangeInputSelect v-model="filter.year"
                                      :options="year"
                                      label="Год"
                                      placeholder="qwe"
                                      nameFrom="year.max"
                                      nameTo="year.min"/>
                    <RangeInput v-model:value="filter.price"
                                nameTo="price.min"
                                nameFrom="price.max"
                                label="Цена"/>
                </div>
                <Radio v-model="filter.steeringWheel" name="steeringWheel" label="Руль" :radios="radios"/>

                <div class="mt-6 flex flex-wrap justify-end items-center gap-10">
                    <div class="flex flex-wrap justify-between items-center gap-6">
                        <div class="text-gray-500 text-sm md:text-base flex">
                            Найдено объявлений: {{ page.props.countTransports }}
                        </div>
                        <button v-if="filter.makers
                            || filter.models
                            || filter.transmission
                            || filter.drive
                            || filter.color
                            || filter.fuelType
                            || filter.transportType
                            || filter.year[0]
                            || filter.year[1]
                            || filter.price[0]
                            || filter.price[1]
                            || filter.steeringWheel"
                                @click="resetFilter"
                                :disabled="processing"
                                class="flex gap-2 text-gray-500 transition-all hover:text-emerald-400 group"
                                :class="{'opacity-50 hover:text-gray-500': processing}">
                            <svg class="transition-all group-hover:fill-emerald-400 fill-gray-500"
                                 :class="{'opacity-50 group-hover:fill-gray-500': processing}"
                                 xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                 width="24px">
                                <path
                                    d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                            </svg>
                            Сбросить все
                        </button>
                    </div>
                    <button
                        v-on:click="submit"
                        :disabled="processing"
                        class="block w-full md:w-auto bg-emerald-400 py-2 px-6 rounded text-white transition-all hover:bg-emerald-300"
                        :class="{'bg-gray-500 hover:bg-gray-500': processing}">
                        Показать
                    </button>
                </div>

                <div class="border-t-2 rounded border-t-emerald-400 my-10"></div>
                <TransportsList/>
            </div>
        </div>
    </Main>
</template>
