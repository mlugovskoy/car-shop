<script setup>

import Admin from "@/Layouts/Admin.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import DangerButton from "@/Components/UI/DangerButton.vue";
import PrimaryButton from "@/Components/UI/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import SecondaryButton from "@/Components/UI/SecondaryButton.vue";

const page = usePage();
const confirmingUserDeletion = ref(false);
const userDeleteId = ref(null);

const userDeleteForm = useForm({
    id: '',
});

const confirmUserDeletion = (id) => {
    confirmingUserDeletion.value = true;
    userDeleteId.value = id;
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    resetConfirmUserDeletion();
};

const resetConfirmUserDeletion = () => {
    userDeleteId.value = null;

    userDeleteForm.reset();
}

const deleteUser = () => {
    if (userDeleteId.value !== null) {
        userDeleteForm.delete(route('admin.users.destroy', userDeleteId.value), {
            preserveScroll: true,
            onSuccess: () => closeModal()
        });
    }
}
</script>

<template>
    <Admin>
        <div v-if="page.props.items && page.props.items.length <= 0"
             class="text-xl flex justify-center items-center h-full">
            Выберите необходимый раздел в меню
            слева
        </div>
        <div v-else class="w-full overflow-x-auto">
            <table class="w-full">
                <thead>
                <tr class="text-left uppercase border-b-2 border-emerald-400">
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Фото</th>
                    <th class="px-4 py-3">Имя</th>
                    <th class="px-4 py-3">Город</th>
                    <th class="px-4 py-3">Почта</th>
                    <th class="px-4 py-3">Админ</th>
                    <th class="px-4 py-3">Управление</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in page.props.items">
                    <td class="px-4 py-3">{{ item.id }}</td>
                    <td class="px-4 py-3 min-w-28">
                        <img class="w-20 h-20 object-cover rounded-md" v-if="item.images[0]"
                             :src="item.images[0].image_path"
                             :alt="item.images[0].image_title">
                    </td>
                    <td class="px-4 py-3">{{ item.name }}</td>
                    <td class="px-4 py-3">{{ item.city }}</td>
                    <td class="px-4 py-3">{{ item.email }}</td>
                    <td class="px-4 py-3">{{ item.is_admin }}</td>
                    <td class="px-4 py-3 flex flex-col gap-2">
                        <PrimaryButton tag="a" :href="route('admin.users.show', item.id)"
                                       class="!px-4 text-xs uppercase">Редактировать
                        </PrimaryButton>
                        <DangerButton @click="confirmUserDeletion(item.id)" class="justify-center">Удалить
                        </DangerButton>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900"
                >
                    Вы уверены, что хотите удалить данную учетную запись?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    После удаления данной учетной записи все ее ресурсы и данные
                    будут удалены навсегда.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Отмена
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': userDeleteForm.processing }"
                        :disabled="userDeleteForm.processing"
                        @click="deleteUser"
                    >
                        Удалить аккаунт
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </Admin>
</template>
