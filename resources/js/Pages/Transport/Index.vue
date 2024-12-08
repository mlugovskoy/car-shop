<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Select from "@/Components/Select.vue";
import Radio from "@/Components/Radio.vue";
import RangeInput from "@/Components/RangeInput.vue";

const page = usePage();

const transports = page.props.transports;
const radios = page.props.fieldsFilters.steeringWheel;
const makers = page.props.fieldsFilters.makers;
const models = page.props.fieldsFilters.models;
const transmission = page.props.fieldsFilters.transmission;
const drive = page.props.fieldsFilters.drive;
const color = page.props.fieldsFilters.color;
const fuelType = page.props.fieldsFilters.fuelType;
const transportType = page.props.fieldsFilters.transportType;

const form = useForm({
    makers: '',
    models: '',
    transmission: '',
    drive: '',
    color: '',
    fuelType: '',
    transportType: '',
    yearFrom: '',
    yearTo: '',
    priceFrom: '',
    priceTo: '',
    steeringWheel: ''
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
    form.yearFrom = '';
    form.yearTo = '';
    form.priceFrom = '';
    form.priceTo = '';
    form.steeringWheel = '';
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
                        <Select v-model="form.makers" :options="makers" name="makers" placeholder="Любая марка"/>
                        <Select v-model="form.models" :options="models" name="models" placeholder="Любая модель"/>
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
                        <RangeInput v-model:modelValueOne="form.yearTo"
                                    v-model:modelValueTwo="form.yearFrom"
                                    inputType="date"
                                    nameTo="yearTo"
                                    nameFrom="yearFrom"
                                    label="Год"/>
                        <RangeInput v-model:modelValueOne="form.priceTo"
                                    v-model:modelValueTwo="form.priceFrom"
                                    nameTo="priceTo"
                                    nameFrom="priceFrom"
                                    label="Цена"/>
                    </div>
                    <Radio v-model="form.steeringWheel" name="steeringWheel" label="Руль" :radios="radios"/>

                    <div class="mt-6 flex justify-end items-center gap-10">
                        <button
                            v-if="form.makers
                            || form.models
                            || form.transmission
                            || form.drive
                            || form.color
                            || form.fuelType
                            || form.transportType
                            || form.yearFrom
                            || form.yearTo
                            || form.priceFrom
                            || form.priceTo
                            || form.steeringWheel"
                            @click="resetFilter"
                            class="flex gap-2 text-gray-500 transition-all hover:text-emerald-400 group">
                            <svg class="transition-all group-hover:fill-emerald-400 fill-gray-500"
                                 xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                 width="24px">
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

                <div v-if="transports.length > 0" class="border-t-2 rounded border-t-emerald-400 mt-10">
                    <div v-for="transport in transports">
                        {{ transport.maker_id }}
                    </div>
                </div>
            </div>
        </div>
    </Main>
</template>
