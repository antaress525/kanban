<template>
    <GuestLayout>
        <Head title="S'inscrire" />

        <div class="space-y-6 w-full max-w-[340px]">
            <form @submit.prevent="submit" class="space-y-6 w-full">
                <!-- First_name $ Last_name -->
                <div class="grid grid-cols-2 gap-2">
                    <div class="space-y-2">
                        <Label for="first_name">Prénom</Label>
                        <Input type="text" id="name" v-model="form.first_name" placeholder="John" />
                        <label class="text-red-500 text-sm" v-if="form.errors.first_name">{{ form.errors.first_name }}</label>
                    </div>
                    <div class="space-y-2">
                        <Label for="last_name">Nom</Label>
                        <Input type="text" id="last_name" v-model="form.last_name" placeholder="Doe" />
                        <label class="text-red-500 text-sm" v-if="form.errors.last_name">{{ form.errors.last_name }}</label>
                    </div>
                </div>
                <!-- Email -->
                <div class="space-y-2">
                    <Label for="email">Email</Label>
                    <Input type="email" id="email" v-model="form.email" placeholder="johhdoe@gmail.com" />
                    <label class="text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</label>
                </div>
                <!-- Password -->
                <div class="space-y-2">
                    <Label for="password">Mot de passe</Label>
                    <Password v-model="form.password" />
                    <label class="text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</label>
                </div>
                <Button class="w-full bg-black text-white">
                    <Loader2 v-if="form.processing" class="w-5 h-5 mr-2 animate-spin" />
                    Créer mon espace Kanban
                </Button>
            </form>
            <div class="flex gap-4 items-center">
                <Separator class="flex-1" />
                <span class="text-neutral-400 text-sm">OU</span>
                <Separator class="flex-1"/>
            </div>
            <SocialAuth />
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Loader2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from "@/components/ui/input";
import { useForm } from '@inertiajs/vue3';
import { Separator } from '@/components/ui/separator'
import Password from '@/components/custom/input/Password.vue';
import SocialAuth from './partials/SocialAuth.vue';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
