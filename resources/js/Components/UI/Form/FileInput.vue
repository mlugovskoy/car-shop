<script setup>
import {onMounted, ref} from "vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    multiple: Boolean,
    images: Object
})

const fileInput = ref(null);
const viewImage = ref([]);

onMounted(() => {
    viewImage.value = [...props.images];
})

const onFileChange = () => {
    const files = event.target.files;
    props.images.push(files);
    if (files.length) {
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            reader.onload = (e) => {
                viewImage.value = [...viewImage.value, e.target.result];
            };
            reader.readAsDataURL(file);
        }
    }
}

const removeImage = (index) => {
    viewImage.value.splice(index, 1);
    props.images.splice(index, 1);

    if (props.images.length === 0) {
        fileInput.value.value = '';
    }
}
</script>

<template>
    <input
        ref="fileInput"
        class="text-sm text-grey-500
                file:transition-all
                file:mr-2 file:py-2 file:px-6
                file:rounded-md file:border-0
                file:text-sm file:font-semibold file:tracking-wider
                file:bg-emerald-400 file:text-white
                hover:file:cursor-pointer hover:file:bg-emerald-500
                file:disabled:bg-gray-400 file:disabled:cursor-auto"
        type="file"
        @change="onFileChange"
        :disabled="!multiple && images.length >= 1"
        accept="image/*"
        :multiple="multiple"
    />
    <div class="flex gap-2 mt-2" v-if="viewImage.length > 0">
        <div class="relative group" v-for="(image, index) in viewImage" :key="index">
            <img :src="image.image_path ? image.image_path : image"
                 :alt="image.image_title ? image.image_title : 'upload_image_' + index"
                 class="object-cover w-20 h-20 rounded-md">
            <DangerButton @click="removeImage(index)"
                          class="opacity-0 invisible group-hover:opacity-80 transition-all group-hover:visible absolute top-0 right-0 bottom-0 left-0 w-full h-full !justify-center !items-center !p-0 !m-0">
                Удалить
            </DangerButton>
        </div>
    </div>
</template>
