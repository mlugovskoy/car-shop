<script setup>

import Admin from "@/Layouts/Admin.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/UI/Form/InputLabel.vue";
import InputError from "@/Components/UI/Form/InputError.vue";
import TextInput from "@/Components/UI/Form/TextInput.vue";
import {ref} from "vue";
import PrimaryButton from "@/Components/UI/PrimaryButton.vue";
import MainTitle from "@/Components/UI/MainTitle.vue";

const page = usePage();
const processing = ref(false);
const siteSettingsForm = useForm({
    yandex_map: page.props.settings?.yandex_map || '',
    yandex_coords: page.props.settings?.yandex_coords || '',
    yandex_zoom: page.props.settings?.yandex_zoom || ''
});

const submit = () => {
    processing.value = true;
    siteSettingsForm.post(route('admin.site_settings.update'), {
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
    <Admin>
        <div class="w-full overflow-x-auto">
            <form class="p-6 flex flex-col gap-4" @submit.prevent="submit" enctype="multipart/form-data"
                  method="POST">
                <div class="flex flex-col gap-2">
                    <MainTitle tag="h3" class="!mb-4">Яндекс карта</MainTitle>
                    <div class="flex-auto">
                        <InputLabel for="yandexMapSetting" value="Ключ API"/>
                        <TextInput
                            id="yandexMapSetting"
                            type="text"
                            v-model="siteSettingsForm.yandex_map"
                            placeholder="https://yandex.ru/maps/..."
                            autocomplete="yandex_map"
                            :error="siteSettingsForm.errors.yandex_map"
                        />
                        <InputError :message="siteSettingsForm.errors.yandex_map" class="mt-2"/>
                    </div>
                    <div class="flex-auto">
                        <InputLabel for="yandexMapCoordsSetting" value="Координаты"/>
                        <TextInput
                            id="yandexMapCoordsSetting"
                            type="text"
                            v-model="siteSettingsForm.yandex_coords"
                            placeholder="37.588144, 55.733842"
                            autocomplete="yandex_coords"
                            :error="siteSettingsForm.errors.yandex_coords"
                        />
                        <InputError :message="siteSettingsForm.errors.yandex_coords" class="mt-2"/>
                    </div>
                    <div class="flex-auto">
                        <InputLabel for="yandexMapZoomSetting" value="Зум карты"/>
                        <TextInput
                            id="yandexMapZoomSetting"
                            type="text"
                            v-model="siteSettingsForm.yandex_zoom"
                            placeholder="10"
                            autocomplete="yandex_zoom"
                            :error="siteSettingsForm.errors.yandex_zoom"
                        />
                        <InputError :message="siteSettingsForm.errors.yandex_zoom" class="mt-2"/>
                    </div>
                </div>

                <PrimaryButton type="submit"
                               class="mx-auto mt-6 block bg-emerald-400 py-2 px-6 rounded-md text-white transition-all hover:bg-emerald-300">
                    Сохранить
                </PrimaryButton>
            </form>
        </div>
    </Admin>
</template>
