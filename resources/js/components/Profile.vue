<template>
    <div @click="clickOutsideElement" ref="profileMain" class="border h-14 flex flex-col gap-y-4 border-neutral-100 rounded-lg py-1.5 shadow-lg overflow-hidden profile">
        <div @click.stop="toggleOpen" class="flex items-center gap-x-3 px-3.5 cursor-pointer">
            <Avatar>
                <AvatarImage :src="`https://ui-avatars.com/api/?name=${authUser.first_name}&background=random`" alt="@unovue" />
                <AvatarFallback>IV</AvatarFallback>
            </Avatar>
            <div class="font-medium space-y-0.5 w-full">
                <p class="text-sm">{{ authUser.first_name }}</p>
                <p class="text-xs text-neutral-400">johndoe@gmail.com</p>
            </div>
            <ChevronsUpDown class="w-3.5 3.5 shrink-0 text-neutral-400" />
        </div>
        <div ref="logoutDiv" class="px-3.5">
            <NavItems :href="route('logout')" method="post" variant="danger" class="logout-button">
                <LogOut class="h-5 w-5" />
                Se deconnecter
            </NavItems>
        </div>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { ChevronsUpDown, LogOut } from 'lucide-vue-next';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import NavItems from './NavItems.vue';

const open = ref(false);
const closeHeight = ref(56);
const padding = ref(16);
const profileMain = ref(null);
const logoutDiv = ref(null);

const page = usePage();
const authUser = computed(() => {
    return page.props.auth.user;
});

const toggleOpen = (e) => {
    const logoutButton = document.querySelector('.logout-button')
    const openHeight = closeHeight.value + logoutButton.getBoundingClientRect().height + padding.value
    if (!open.value) {
        profileMain.value.style.height = `${openHeight}px`
        open.value = true
    } else {
        profileMain.value.style.height = `${closeHeight.value}px`
        open.value = false
    }
}

const close = (e) => {
    if (open.value) {
        profileMain.value.style.height = `${closeHeight.value}px`
        open.value = false
    }
}
onMounted(() => {
    document.body.addEventListener('click', close)
})

onUnmounted(() => {
    document.body.removeEventListener('click', close)
})

</script>

<style scoped>
.profile {
    transition: height 0.3s ease-in-out;
}
</style>
