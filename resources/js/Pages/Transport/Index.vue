<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, router, useForm, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Breadcrumbs from "@/Components/UI/Breadcrumbs.vue";
import Select from "@/Components/UI/Form/Select.vue";
import Radio from "@/Components/UI/Form/Radio.vue";
import RangeInput from "@/Components/UI/Form/RangeInput.vue";
import RangeInputSelect from "@/Components/UI/Form/RangeInputSelect.vue";
import {onMounted, reactive, ref} from "vue";
import TransportsList from "@/Components/TransportsList/TransportsList.vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/UI/Form/InputLabel.vue";
import TextInput from "@/Components/UI/Form/TextInput.vue";
import PrimaryButton from "@/Components/UI/PrimaryButton.vue";
import InputError from "@/Components/UI/Form/InputError.vue";
import DangerButton from "@/Components/UI/DangerButton.vue";

const page = usePage();
const processing = ref(false);
const createdModal = ref(false);
const fileInput = ref(null);

const createForm = useForm({
    makers: '',
    models: '',
    city: '',
    vin: '',
    phone: '',
    description: '',
    engine: '',
    power: '',
    transmission: '',
    drive: '',
    mileage: '',
    color: '',
    steering_wheel: '',
    country: '',
    tact: '',
    fuel_supply_type: '',
    doors: '',
    seats: '',
    year: '',
    fuel_type_id: '',
    transport_type_id: '',
    price: '',
    images: '',
})

const resetCreatedForm = () => {
    createForm.reset('makers', 'models', 'city', 'vin', 'phone', 'description', 'engine', 'power', 'transmission', 'drive', 'mileage', 'color', 'steering_wheel', 'country', 'tact', 'fuel_supply_type', 'doors', 'seats', 'year', 'fuel_type_id', 'transport_type_id', 'price');
    createForm.images = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const submitCreateForm = () => {
    createForm.post(route('transport.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        }
    })
}

const confirmUserDeletion = () => {
    createdModal.value = true;
};

const closeModal = () => {
    createdModal.value = false;

    resetCreatedForm()
};

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
        filter.makers = pathname[2]
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
                    <PrimaryButton @click="confirmUserDeletion" v-if="page.props.auth.user !== null">
                        Добавить объявление
                    </PrimaryButton>
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
                    <PrimaryButton
                        v-on:click="submit"
                        :disabled="processing"
                        :class="{'bg-gray-500 hover:bg-gray-500': processing}">
                        Показать
                    </PrimaryButton>
                </div>

                <div class="border-t-2 rounded-md border-t-emerald-400 my-10"></div>
                <TransportsList/>
            </div>
        </div>
    </Main>
    <Modal :show="createdModal" @close="closeModal">
        <header
            class="p-6 text-xl sm:text-2xl flex items-center border-b-2 border-b-emerald-400 text-gray-500 font-bold justify-between">
            Добавление объявления
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
        <form class="p-6" @submit.prevent="submitCreateForm" enctype="multipart/form-data" method="POST">
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <Select
                    :options="makers"
                    placeholder="Выберите марку"
                    required
                    name="createFormMakers"
                    v-model="createForm.makers"/>
                <Select
                    :options="models"
                    placeholder="Выберите модель"
                    required
                    name="createFormModels"
                    v-model="createForm.models"/>
                <Select
                    :options="transmission"
                    placeholder="Выберите трансмиссию"
                    required
                    name="createFormTransmission"
                    v-model="createForm.transmission"/>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mb-6 pb-6 border-b-2 border-emerald-400 border-opacity-40">
                <Select
                    :options="drive"
                    placeholder="Выберите привод"
                    required
                    name="createFormDrive"
                    v-model="createForm.drive"/>
                <Select
                    :options="fuelType"
                    placeholder="Выберите тип топлива"
                    required
                    name="createFormFuelType"
                    v-model="createForm.fuel_type_id"/>
                <Select
                    :options="transportType"
                    placeholder="Выберите тип транспорта"
                    required
                    name="createFormTransportType"
                    v-model="createForm.transport_type_id"/>
            </div>

            <div class="flex flex-wrap gap-4 mb-6">
                <div class="flex-auto">
                    <InputLabel for="createFormMileage" value="Пробег"/>
                    <TextInput
                        id="createFormMileage"
                        type="text"
                        v-model="createForm.mileage"
                        placeholder="500"
                        autocomplete="mileage"
                        :error="createForm.errors.mileage"
                    />
                    <InputError :message="createForm.errors.mileage" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormSteeringWheel" value="Руль"/>
                    <TextInput
                        id="createFormSteeringWheel"
                        type="text"
                        v-model="createForm.steering_wheel"
                        placeholder="Левый"
                        autocomplete="steering_wheel"
                    />
                    <InputError :message="createForm.errors.steering_wheel" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormFuelSupplyType" value="Система подачи топлива"/>
                    <TextInput
                        id="createFormFuelSupplyType"
                        type="text"
                        v-model="createForm.fuel_supply_type"
                        placeholder="Карбюратор"
                        autocomplete="fuel_supply_type"
                    />
                    <InputError :message="createForm.errors.fuel_supply_type" class="mt-2"/>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mb-6">
                <div class="flex-auto">
                    <InputLabel for="createFormEngine" value="Двигатель"/>
                    <TextInput
                        id="createFormEngine"
                        type="text"
                        v-model="createForm.engine"
                        placeholder="Двигатель"
                        autocomplete="engine"
                    />
                    <InputError :message="createForm.errors.engine" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormPower" value="Мощность"/>
                    <TextInput
                        id="createFormPower"
                        type="number"
                        v-model="createForm.power"
                        placeholder="50"
                        autocomplete="power"
                    />
                    <InputError :message="createForm.errors.power" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormTact" value="Такт двигателя"/>
                    <TextInput
                        id="createFormTact"
                        type="number"
                        v-model="createForm.tact"
                        placeholder="4"
                        autocomplete="power"
                    />
                    <InputError :message="createForm.errors.tact" class="mt-2"/>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mb-6">
                <div class="flex-auto">
                    <InputLabel for="createFormColor" value="Цвет"/>
                    <TextInput
                        id="createFormColor"
                        type="text"
                        v-model="createForm.color"
                        placeholder="Зеленый"
                        autocomplete="color"
                    />
                    <InputError :message="createForm.errors.color" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormDoors" value="Количество дверей"/>
                    <TextInput
                        id="createFormDoors"
                        type="number"
                        v-model="createForm.doors"
                        placeholder="4"
                        autocomplete="doors"
                    />
                    <InputError :message="createForm.errors.doors" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormSeats" value="Количество мест"/>
                    <TextInput
                        id="createFormSeats"
                        type="number"
                        v-model="createForm.seats"
                        placeholder="4"
                        autocomplete="seats"
                    />
                    <InputError :message="createForm.errors.seats" class="mt-2"/>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mb-6">
                <div class="flex-auto">
                    <InputLabel for="createFormCountry" value="Страна"/>
                    <TextInput
                        id="createFormCountry"
                        type="text"
                        v-model="createForm.country"
                        placeholder="Россия"
                        autocomplete="country"
                    />
                    <InputError :message="createForm.errors.country" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormCity" value="Город"/>
                    <TextInput
                        id="createFormCity"
                        type="text"
                        v-model="createForm.city"
                        placeholder="Москва"
                        autocomplete="city"
                    />
                    <InputError :message="createForm.errors.city" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormYear" value="Год"/>
                    <TextInput
                        id="createFormYear"
                        type="number"
                        v-model="createForm.year"
                        placeholder="2000"
                        autocomplete="year"
                    />
                    <InputError :message="createForm.errors.year" class="mt-2"/>
                </div>
            </div>

            <div class="flex gap-4 mb-6 pb-6 border-b-2 border-emerald-400 border-opacity-40">
                <div class="flex-auto">
                    <InputLabel for="createFormVin" value="Vin"/>
                    <TextInput
                        id="createFormVin"
                        type="text"
                        v-model="createForm.vin"
                        placeholder="Z12CB34AACR567890"
                        autocomplete="vin"
                    />
                    <InputError :message="createForm.errors.vin" class="mt-2"/>
                </div>
            </div>

            <div class="flex gap-4 flex-wrap mb-8">
                <div class="flex-auto">
                    <InputLabel for="createFormPhone" value="Телефон"/>
                    <TextInput
                        id="createFormPhone"
                        type="number"
                        v-model="createForm.phone"
                        placeholder="7914561868"
                        autocomplete="phone"
                    />
                    <InputError :message="createForm.errors.phone" class="mt-2"/>
                </div>
                <div class="flex-auto">
                    <InputLabel for="createFormPrice" value="Стоимость" required/>
                    <TextInput
                        id="createFormPrice"
                        type="number"
                        required
                        v-model="createForm.price"
                        placeholder="5 000 000"
                        autocomplete="price"
                    />
                    <InputError :message="createForm.errors.price" class="mt-2"/>
                </div>
            </div>

            <div class="mb-6">
                    <textarea
                        class="block w-full h-full rounded-md p-2.5 border-2 border-emerald-400 focus:border-emerald-400 text-sm"
                        id="createFormDescription"
                        name="createFormDescription"
                        placeholder="Описание"
                        v-model="createForm.description"></textarea>
            </div>

            <div class="flex flex-col mb-8">
                <label class="text-sm text-gray-500 mb-2 cursor-pointer" for="images">Фотографии</label>
                <input
                    ref="fileInput"
                    class="text-sm text-grey-500
                                file:transition-all
                                file:mr-2 file:py-2 file:px-6
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold file:tracking-wider
                                file:bg-emerald-400 file:text-white
                                hover:file:cursor-pointer hover:file:bg-emerald-500"
                    type="file" id="images" name="images" multiple
                    @change="createForm.images = $event.target.files">
            </div>

            <progress v-if="createForm.progress" :value="createForm.progress.percentage" max="100">
                {{ createForm.progress.percentage }}%
            </progress>
            <PrimaryButton type="submit"
                           :disabled="createForm.processing"
                           class="ml-auto mt-6 block bg-emerald-400 py-2 px-6 rounded-md text-white transition-all hover:bg-emerald-300">
                Добавить
            </PrimaryButton>
        </form>
    </Modal>
</template>
