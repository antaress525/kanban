<template>
    <GuestLayout>
        <Head title="Se connecter" />
        <div class="space-y-6 w-full max-w-[340px]">
            <form @submit.prevent="submit" class="space-y-6 w-full">
                <!-- Credential error -->
                <div v-if="form.errors.credential" class="rounded-lg bg-red-500/15 p-6 text-red-500 text-sm">
                    {{ form.errors.credential }}
                </div>
                <!-- Email -->
                <div class="space-y-2">
                    <Label for="email">Email</Label>
                    <Input type="email" id="email" v-model="form.email" placeholder="johhdoe@gmail.com" />
                    <label class="text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</label>
                </div>
                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Mot de passe</Label>
                        <Link :href="route('password.request')" class="text-xs text-gray-600 hover:text-gray-900">Mot de passe oublier ?</Link>
                    </div>
                    <Password v-model="form.password" />
                    <label class="text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</label>
                </div>
                <Button class="w-full bg-black text-white">
                    <Loader2 v-if="form.processing" class="w-5 h-5 mr-2 animate-spin" />
                    <LogIn v-else="form.processing" class="w-5 h-5 mr-2" />
                    Accéder à mon espace
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
import { useForm } from '@inertiajs/vue3';
import { Loader2, LogIn } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from "@/components/ui/input";
import { Separator } from '@/components/ui/separator'
import Password from '@/components/custom/input/Password.vue';
import SocialAuth from './partials/SocialAuth.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
