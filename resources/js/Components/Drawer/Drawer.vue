<script setup>
import DrawerHead from "@/Components/Drawer/DrawerHead.vue";
import DrawerItemList from "@/Components/Drawer/DrawerItemList.vue";
import {inject, onMounted, onUnmounted, provide, ref, watch} from "vue";
import DrawerBottom from "@/Components/Drawer/DrawerBottom.vue";
import {router, usePage} from "@inertiajs/vue3";

const page = usePage();
const processing = ref(false);
const props = defineProps({
    show: {
        type: Boolean,
        default: false,
        required: true
    }
});

const changeDrawerStatus = inject('changeDrawerStatus');

const addAndDeleteToCart = (item) => {
    if (checkAdded(item)) {
        page.props.cart.items.splice(page.props.cart.items.indexOf(item), 1)
        deleteCartItemToDb(item.id);
    } else {
        page.props.cart.items.push(item);
        addCartItemToDb(item);
    }
}

const checkAdded = (item) => {
    return page.props.cart.items.find(cartItem => cartItem.id === item.id)
}

const addCartItemToDb = (item) => {
    router.post(route('cart.add'), {item}, {
        preserveScroll: true,
        onSuccess: () => processing.value = false,
        onError: (errors) => {
            processing.value = false;
            alert('Произошла ошибка при добавлении в корзину.');
            console.error(errors);
        }
    })
}

const deleteCartItemToDb = (id) => {
    router.post(route('cart.delete', id), {}, {
        preserveScroll: true,
        onSuccess: () => processing.value = false,
        onError: (errors) => {
            processing.value = false;
            alert('Произошла ошибка при удалении из корзины.');
            console.error(errors);
        }
    })
}

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show === true) {
        changeDrawerStatus();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
});

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
    },
);

provide('addAndDeleteToCart', addAndDeleteToCart);
</script>

<template>
    <div v-if="show" @click="changeDrawerStatus"
         class="fixed top-0 left-0 h-full opacity-50 w-full z-10 bg-black"></div>

    <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="translate-x-[300px] opacity-0"
        enter-to-class="translate-x-[0px] opacity-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="translate-x-[0px] opacity-100"
        leave-to-class="translate-x-[300px] opacity-0">
        <div v-if="show" class="bg-white w-96 h-full max-h-screen fixed right-0 z-20 top-0 p-6">
            <DrawerHead/>

            <DrawerItemList :items="page.props.cart.items"/>

            <DrawerBottom :count="page.props.cart.count" :total="page.props.cart.total"/>
        </div>
    </transition>
</template>
