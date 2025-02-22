<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import InputError from "@/Components/UI/Form/InputError.vue";
import InputLabel from "@/Components/UI/Form/InputLabel.vue";
import PrimaryButton from "@/Components/UI/PrimaryButton.vue";
import TextInput from "@/Components/UI/Form/TextInput.vue";
import {ref} from "vue";

const page = usePage();

const processing = ref(false);

let transportsId = [];

page.props.items.forEach((item) => {
    transportsId.push(item.transport.id)
})

const orderForm = useForm({
    firstName: '',
    lastName: '',
    city: '',
    email: '',
    phone: '',
    price: page.props.cart.total.toString(),
    transports_id: transportsId
})

const submit = () => {
    processing.value = true;
    orderForm.post(route('order.store'), {
        onSuccess: () => {
            processing.value = false
        },
        onError: (e) => {
            console.error(e)
        }
    })
}
</script>

<template>
    <Head title="Оформление заказа"/>

    <Main>
        <div class="mx-auto pt-12 max-w-7xl px-6 lg:px-8">
            <MainTitle :href="route('order.create')">Оформление заказа</MainTitle>
        </div>

        <div class="flex gap-12 mx-auto max-w-7xl mb-14 sm:px-6 lg:px-8"
             v-if="page.props.items && page.props.items.length > 0">
            <div class="bg-white w-4/6 p-4 shadow sm:rounded-lg sm:p-8">
                <form class="p-6 flex flex-col gap-4" @submit.prevent="submit" enctype="multipart/form-data"
                      method="POST">
                    <div class="flex-auto">
                        <InputLabel for="orderCreateFirstName" value="Имя"/>
                        <TextInput
                            id="orderCreateFirstName"
                            type="text"
                            required="false"
                            v-model="orderForm.firstName"
                            placeholder="Имя"
                            autocomplete="firstName"
                            :error="orderForm.errors.firstName"
                        />
                        <InputError :message="orderForm.errors.firstName" class="mt-2"/>
                    </div>
                    <div class="flex-auto">
                        <InputLabel for="orderCreateLastName" value="Фамилия"/>
                        <TextInput
                            id="orderCreateLastName"
                            type="text"
                            required="false"
                            v-model="orderForm.lastName"
                            placeholder="Фамилия"
                            autocomplete="lastName"
                            :error="orderForm.errors.lastName"
                        />
                        <InputError :message="orderForm.errors.lastName" class="mt-2"/>
                    </div>
                    <div class="flex-auto">
                        <InputLabel for="orderCreateCity" required value="Город"/>
                        <TextInput
                            id="orderCreateCity"
                            type="text"
                            v-model="orderForm.city"
                            placeholder="Москва"
                            autocomplete="city"
                            :error="orderForm.errors.city"
                        />
                        <InputError :message="orderForm.errors.city" class="mt-2"/>
                    </div>
                    <div class="flex-auto">
                        <InputLabel for="orderCreateEmail" required value="Email"/>
                        <TextInput
                            id="orderCreateEmail"
                            type="text"
                            v-model="orderForm.email"
                            placeholder="example@example.com"
                            autocomplete="email"
                            :error="orderForm.errors.email"
                        />
                        <InputError :message="orderForm.errors.email" class="mt-2"/>
                    </div>
                    <div class="flex-auto">
                        <InputLabel for="createFormPhone" required value="Телефон"/>
                        <TextInput
                            id="createFormPhone"
                            type="text"
                            v-model="orderForm.phone"
                            placeholder="7914561868"
                            autocomplete="phone"
                        />
                        <InputError :message="orderForm.errors.phone" class="mt-2"/>
                    </div>

                    <input type="hidden" v-model="orderForm.price">
                    <input type="hidden" v-model="orderForm.transports_id">

                    <PrimaryButton type="submit"
                                   class="mx-auto mt-6 block bg-emerald-400 py-2 px-6 rounded-md text-white transition-all hover:bg-emerald-300">
                        Оформить заказ
                    </PrimaryButton>
                </form>
            </div>
            <div class="bg-white w-2/6 p-4 flex self-start flex-col shadow sm:rounded-lg sm:p-8">
                <h4 class="text-base mb-6 font-semibold md:text-xl">Товаров в заказе: {{ page.props.total }}</h4>
                <div class="flex flex-col gap-4 mb-6">
                    <div class="flex gap-4" v-for="item in page.props.items">
                        <img class="w-16 h-16 object-cover rounded-md" :src="item.images[0].image_path"
                             :alt="item.title">
                        <div class="flex flex-auto flex-col text-gray-500">
                            <h4 class="mb-2">{{ item.title }}</h4>
                            <b class="text-sm">{{ item.price }}</b>
                        </div>
                    </div>
                </div>
                <h5 class="text-right font-semibold">Общая стоимость</h5>
                <p class="mt-auto text-right text-2xl">
                    {{ page.props.total_price ? page.props.total_price : '0 ₽' }}
                </p>
            </div>
        </div>
        <div class="flex gap-12 mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8"
             v-else>
            <div class="bg-white w-full p-4 shadow text-center text-xl text-gray-500 sm:rounded-lg sm:p-8">
                Добавьте товары в корзину для оформления заказа
            </div>
        </div>
    </Main>
</template>
