<template>
    <BaseModal v-if="open" @click.self="close">
        <div class="bg-white rounded-xl w-full max-w-[432px] px-0.5 pt-0.5 pb-6">
            <!-- Cover image -->
            <div class="relative min-h-28 bg-yellow-500 rounded-xl">
                <Avatar size="20" class="border-4 border-white absolute top-20 left-4">
                    <AvatarImage :src="`https://ui-avatars.com/api/?name=${authUser.first_name}&background=random`" alt="@unovue" />
                    <AvatarFallback>CN</AvatarFallback>
                </Avatar>
            </div>
            <!-- Content -->
            <div class="px-6">
                <!-- Upload image section -->
                <div class="flex gap-x-2 items-center justify-end mt-1.5">
                    <Button size="xs" variant="outline">Photos</Button>
                    <Button size="xs" variant="outline">Changer l'arriere plan</Button>
                </div>
                <!-- Upload image section -->
                <div class="mt-3.5 space-y-0">
                    <p class="font-medium">{{ authUser.first_name }} {{ authUser.last_name }}</p>
                    <p class="text-sm text-neutral-400">{{ authUser.email }}</p>
                </div>
                <!-- Tabs section -->
                <Tabs2 class="mt-8">
                    <template #tablist>
                        <TabList2 :tabs="['Profile', 'Securiter']" />
                    </template>
                    <TabPannel2 :index="0">
                        <form @submit.prevent="updateProfile" class="space-y-4">
                            <div class="grid grid-cols-2 gap-x-4">
                                <div class="grid w-full items-center gap-2">
                                    <Label for="last_name">Nom</Label>
                                    <Input placeholder="Votre nom" v-model="profileForm.first_name"  id="last_name" class="shadow-none"/>
                                    <InputError v-if="profileForm.errors.first_name">{{ profileForm.errors.first_name }}</InputError>
                                </div>
                                <div class="grid w-full items-center gap-2">
                                    <Label for="first_name">Prenom</Label>
                                    <Input placeholder="Votre prenom" v-model="profileForm.last_name"  id="first_name" class="shadow-none"/>
                                    <InputError v-if="profileForm.errors.last_name">{{ profileForm.errors.last_name }}</InputError>
                                </div>
                            </div>
                            <div class="grid w-full items-center gap-2">
                                <Label for="email">Email</Label>
                                <Input type="email" placeholder="johndoe@gmail.com" v-model="profileForm.email"  id="email" class="shadow-none"/>
                                <InputError v-if="profileForm.errors.email">{{ profileForm.errors.email }}</InputError>
                            </div>
                            <!-- Button -->
                            <div class="flex items-center justify-end gap-x-2">
                                <Button @click="close" type="button" variant="ghost">Annuler</Button>
                                <Button>
                                    <Loader2 v-if="profileForm.processing" class="w-5 h-5 animate-spin" />
                                    Sauvegarder
                                </Button>
                            </div>
                        </form>
                    </TabPannel2>
                    <TabPannel2 :index="1">
                        
                    </TabPannel2>
                </Tabs2>
            </div>
        </div>
    </BaseModal>
</template>

<script setup>
import BaseModal from '@/components/BaseModal.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import Button from '@/components/ui/button/Button.vue'
import Tabs2 from '@/components/Tabs2/Tabs2.vue'
import TabList2 from '@/components/Tabs2/TabList2.vue'
import TabPannel2 from '@/components/Tabs2/TabPannel2.vue'
import Label from '@/components/ui/label/Label.vue'
import Input from '@/components/ui/input/Input.vue'
import InputError from '@/components/InputError.vue'
import { Loader2 } from 'lucide-vue-next'

defineProps({
    open: {
        type: Boolean,
        default: false
    }
})
const emits = defineEmits(['close'])
const page = usePage()
const authUser = computed(() => page.props.auth.user)

const profileForm = useForm({
    first_name: authUser.value.first_name,
    last_name: authUser.value.last_name,
    email: authUser.value.email,
})

const close = () => {
    profileForm.resetAndClearErrors()
    emits('close')
}

const updateProfile = () => {
    profileForm.put(route('profile.update'))
}
</script>