<script setup>

import Admin from "@/Layouts/Admin.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/UI/Form/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/UI/Form/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";
import FileInput from "@/Components/UI/Form/FileInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const page = usePage();

const updatedUserForm = useForm({
    name: page.props.item.name,
    city: page.props.item.city,
    email: page.props.item.email,
    is_admin: page.props.item.is_admin,
    images: page.props.item.images,
});

const submitUpdatedUserForm = () => {
    updatedUserForm.post(route('admin.users.update', page.props.item.id), {
        preserveScroll: true,
        onSuccess: () => {
            resetConfirmUserDeletion()
        }
    })
}

const resetConfirmUserDeletion = () => {
    updatedUserForm.reset();
}

</script>

<template>
    <Admin>
        <form class="w-full flex flex-col gap-4" @submit.prevent="submitUpdatedUserForm" enctype="multipart/form-data"
              method="POST">
            <div>
                <InputLabel for="name" value="Имя"/>
                <TextInput
                    id="name"
                    type="text"
                    v-model="updatedUserForm.name"
                    placeholder="Имя пользователя"
                    autocomplete="name"
                />
                <InputError :message="updatedUserForm.errors.name" class="mt-2"/>
            </div>
            <div>
                <InputLabel for="city" value="Город"/>
                <TextInput
                    id="city"
                    type="text"
                    v-model="updatedUserForm.city"
                    placeholder="Москва"
                    autocomplete="city"
                />
                <InputError :message="updatedUserForm.errors.city" class="mt-2"/>
            </div>
            <div>
                <InputLabel for="email" value="Почта"/>
                <TextInput
                    id="email"
                    type="text"
                    v-model="updatedUserForm.email"
                    placeholder="example@example.com"
                    autocomplete="email"
                />
                <InputError :message="updatedUserForm.errors.email" class="mt-2"/>
            </div>
            <div>
                <InputLabel for="is_admin" value="Администратор"/>
                <Checkbox v-model="updatedUserForm.is_admin" :checked="updatedUserForm.is_admin"/>
                <InputError :message="updatedUserForm.errors.is_admin" class="mt-2"/>
            </div>
            <div>
                <InputLabel for="image" value="Фото"/>
                <FileInput :images="updatedUserForm.images"/>
                <InputError :message="updatedUserForm.errors.images" class="mt-2"/>
            </div>

            <progress v-if="updatedUserForm.progress" :value="updatedUserForm.progress.percentage" max="100">
                {{ updatedUserForm.progress.percentage }}%
            </progress>
            <PrimaryButton
                type="submit"
                :disabled="updatedUserForm.processing"
                class="mx-auto">
                Обновить
            </PrimaryButton>
        </form>
    </Admin>
</template>
