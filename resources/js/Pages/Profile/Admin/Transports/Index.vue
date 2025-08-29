<script setup>

import Admin from "@/Layouts/Admin.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import DangerButton from "@/Components/UI/DangerButton.vue";
import PrimaryButton from "@/Components/UI/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import SecondaryButton from "@/Components/UI/SecondaryButton.vue";
import FlashMessage from "@/Components/FlashMessage/FlashMessage.vue";
import Pagination from "@/Components/Pagination.vue";

const page = usePage();
const confirmingDeleting = ref(false);
const deletedId = ref(null);

const deletingForm = useForm({
    id: '',
});

const updatingForm = useForm({})

const confirmDeletingForm = (id) => {
    confirmingDeleting.value = true;
    deletedId.value = id;
};

const closeModal = () => {
    confirmingDeleting.value = false;

    resetConfirmTransportDeletion();
};

const resetConfirmTransportDeletion = () => {
    deletedId.value = null;

    deletingForm.reset();
}

const updateTransport = (id) => {
    updatingForm.post(route('admin.transports.update', id), {
        preserveScroll: true
    });
}

const deleteTransport = () => {
    if (deletedId.value !== null) {
        deletingForm.delete(route('admin.transports.destroy', deletedId.value), {
            preserveScroll: true,
            onSuccess: () => closeModal()
        });
    }
}
</script>

<template>
    <Admin>
        <div class="w-full overflow-x-auto">
            <table class="w-full">
                <thead>
                <tr class="text-left uppercase border-b-2 border-emerald-400">
                    <th class="px-4 py-3 text-nowrap">ID</th>
                    <th class="px-4 py-3 text-nowrap">Опубликовано</th>
                    <th class="px-4 py-3 text-nowrap">Фото</th>
                    <th class="px-4 py-3 text-nowrap">Модель</th>
                    <th class="px-4 py-3 text-nowrap">Марка</th>
                    <th class="px-4 py-3 text-nowrap">Тип топлива</th>
                    <th class="px-4 py-3 text-nowrap">Тип транспорта</th>
                    <th class="px-4 py-3 text-nowrap">Город</th>
                    <th class="px-4 py-3 text-nowrap">Год</th>
                    <th class="px-4 py-3 text-nowrap">Мощность</th>
                    <th class="px-4 py-3 text-nowrap">Двигатель</th>
                    <th class="px-4 py-3 text-nowrap">Топливная система</th>
                    <th class="px-4 py-3 text-nowrap">Пробег</th>
                    <th class="px-4 py-3 text-nowrap">Цена</th>
                    <th class="px-4 py-3 text-nowrap">Описание</th>
                    <th class="px-4 py-3 text-nowrap">ID пользователя</th>
                    <th class="px-4 py-3 text-nowrap">Дата публикации</th>
                    <th class="px-4 py-3 text-nowrap">Управление</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in page.props.items.data">
                    <td class="px-4 py-3">{{ item.id }}</td>
                    <td class="px-4 py-3">
                        <span v-if="item.active" class="text-center block">
                            <svg class="w-full"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 30 30"
                                 width="20px"
                                 height="20px">
                                <path class="fill-emerald-400"
                                      d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                            </svg>
                        </span>
                    </td>
                    <td class="px-4 py-3 min-w-28">
                        <img class="w-20 h-20 object-cover rounded-md" v-if="item.images[0]"
                             :src="item.images[0].image_path"
                             :alt="item.images[0].image_title">
                    </td>
                    <td class="px-4 py-3">{{ item.model.name }}</td>
                    <td class="px-4 py-3">{{ item.maker.name }}</td>
                    <td class="px-4 py-3">{{ item.fuel_type.name }}</td>
                    <td class="px-4 py-3">{{ item.transport_type.name }}</td>
                    <td class="px-4 py-3">{{ item.city }}</td>
                    <td class="px-4 py-3">{{ item.year }}</td>
                    <td class="px-4 py-3">{{ item.power }}</td>
                    <td class="px-4 py-3">{{ item.engine }}</td>
                    <td class="px-4 py-3">{{ item.fuel_supply_type }}</td>
                    <td class="px-4 py-3">{{ item.mileage }}</td>
                    <td class="px-4 py-3 min-w-36">{{ item.price }}</td>
                    <td class="px-4 py-3 min-w-96">{{ item.description }}</td>
                    <td class="px-4 py-3">{{ item.user.id }}</td>
                    <td class="px-4 py-3">{{ item.published_at }}</td>
                    <td class="px-4 py-3 flex flex-col gap-2">
                        <PrimaryButton @click="updateTransport(item.id)"
                                       class="!px-4 text-xs uppercase">
                            {{ !item.active ? 'Опубликовать' : 'Скрыть' }}
                        </PrimaryButton>
                        <DangerButton @click="confirmDeletingForm(item.id)" class="justify-center">
                            Удалить
                        </DangerButton>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <Pagination :links="page.props.items.meta.links"/>
        <Modal :show="confirmingDeleting" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900"
                >
                    Вы уверены, что хотите удалить данную запись?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    После удаления данной записи все ее ресурсы и данные будут удалены навсегда.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Отмена
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': deletingForm.processing }"
                        :disabled="deletingForm.processing"
                        @click="deleteTransport"
                    >
                        Удалить
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </Admin>
    <FlashMessage v-if="page.props.flash.success" :key="page.props.flash.success" :message="page.props.flash.success"/>
</template>
